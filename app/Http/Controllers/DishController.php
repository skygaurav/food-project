<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDishRequest;
use App\Mail\DishSubmittedMail;
use App\Mail\NewDishSubmittedAdminMail;
use App\Models\AdminSetting;
use App\Models\Dish;
use App\Models\DishImage;
use App\Models\Restaurant;
use App\Services\MailService;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for managing dishes (public and user-owned).
 *
 * Handles CRUD operations for dishes, image uploads, and restaurant associations.
 *
 * @package App\Http\Controllers
 */
class DishController extends Controller
{
    /**
     * Dish status constants.
     */
    private const STATUS_APPROVED = 'approved';
    private const STATUS_PENDING = 'pending';

    /**
     * Default pagination values.
     */
    private const DEFAULT_PER_PAGE = 12;
    private const DEFAULT_MY_DISHES_PER_PAGE = 10;

    /**
     * Image quality settings.
     */
    private const IMAGE_QUALITY = 90;

    /**
     * Get all dishes for public listing (approved only).
     *
     * Supports filtering by category, city, and search query.
     * Supports sorting by popularity, rating, name, or date.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Dish::query()
            ->with(['restaurant.categories', 'images'])
            ->where('status', 'approved')
            ->whereHas('restaurant', fn ($q) => $q->where('is_approved', true))
            ->withCount([
                'reviews as reviews_count',
                'reactions as likes_count' => fn ($relation) => $relation->where('type', 'like'),
            ])
            ->withAvg('reviews', 'rating');

        if ($request->filled('category')) {
            $categoryValue = $request->string('category')->toString();
            $query->whereHas('restaurant.categories', function ($relation) use ($categoryValue): void {
                // Support both ID and slug
                if (is_numeric($categoryValue)) {
                    $relation->where('id', $categoryValue);
                } else {
                    $relation->where('slug', $categoryValue);
                }
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('restaurant', function ($relation) use ($request): void {
                $relation->where('city', $request->string('city')->toString());
            });
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%")
                  ->orWhereHas('restaurant', fn ($r) => $r->where('name', 'like', "%{$search}%"));
            });
        }

        $sort = $request->string('sort')->toString();
        switch ($sort) {
            case 'popular':
                $query->orderByDesc('likes_count');
                break;
            case 'rating':
            case 'top-reviewed':
                $query->orderByDesc('reviews_avg_rating');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }

        $perPage = $request->integer('per_page', self::DEFAULT_PER_PAGE);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Get popular dishes sorted by likes and reviews.
     *
     * Calculates popularity score: likes (weighted x2) + reviews count + average rating.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function popular(Request $request): JsonResponse
    {
        $perPage = $request->integer('per_page', self::DEFAULT_PER_PAGE);
        
        $query = Dish::query()
            ->with(['restaurant.categories', 'images'])
            ->where('status', 'approved')
            ->whereHas('restaurant', fn ($q) => $q->where('is_approved', true))
            ->withCount([
                'reviews as reviews_count',
                'reactions as likes_count' => fn ($relation) => $relation->where('type', 'like'),
                'reactions as dislikes_count' => fn ($relation) => $relation->where('type', 'dislike'),
            ])
            ->withAvg('reviews', 'rating');

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->whereHas('restaurant.categories', function ($relation) use ($request): void {
                $relation->where('slug', $request->string('category')->toString());
            });
        }

        // Filter by city if provided
        if ($request->filled('city')) {
            $query->whereHas('restaurant', function ($relation) use ($request): void {
                $relation->where('city', $request->string('city')->toString());
            });
        }

        // Sort by popularity score: likes (weighted x2) + reviews count + average rating
        // Use subqueries for proper ordering since aliases can't be used in ORDER BY directly
        $query->addSelect([
            DB::raw('(
                (SELECT COUNT(*) FROM dish_reactions WHERE dish_reactions.dish_id = dishes.id AND dish_reactions.type = "like") * 2 +
                (SELECT COUNT(*) FROM reviews WHERE reviews.dish_id = dishes.id) +
                COALESCE((SELECT AVG(rating) FROM reviews WHERE reviews.dish_id = dishes.id), 0)
            ) as popularity_score')
        ])
        ->orderByDesc('popularity_score');

        return response()->json($query->paginate($perPage));
    }

    /**
     * Get current user's dishes (all statuses).
     *
     * Returns paginated list of dishes owned by the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myDishes(Request $request): JsonResponse
    {
        $perPage = $request->integer('per_page', self::DEFAULT_MY_DISHES_PER_PAGE);
        $page = $request->integer('page', 1);
        
        $query = Dish::query()
            ->with(['restaurant', 'images'])
            ->where('user_id', auth()->id())
            ->latest();
        
        $total = $query->count();
        $dishes = $query->skip(($page - 1) * $perPage)->take($perPage)->get();
        
        $mappedDishes = $dishes->map(function ($dish) {
            // Find primary image or use first one
            $primaryImage = $dish->images->firstWhere('is_primary', true) ?? $dish->images->first();
            
            return [
                'id' => $dish->id,
                'name' => $dish->name,
                'slug' => $dish->slug,
                'status' => $dish->status,
                'comment' => $dish->comment,
                'meal_cost' => $dish->meal_cost,
                'good_date_spot' => $dish->good_date_spot,
                'reservation' => $dish->reservation,
                'phone' => $dish->phone,
                'website' => $dish->website,
                'restaurant' => $dish->restaurant ? [
                    'id' => $dish->restaurant->id,
                    'name' => $dish->restaurant->name,
                    'city' => $dish->restaurant->city,
                ] : null,
                'images' => $dish->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => $image->path,
                        'is_primary' => $image->is_primary,
                    ];
                }),
                'image_url' => $primaryImage?->path 
                    ? '/storage/' . $primaryImage->path 
                    : null,
                'created_at' => $dish->created_at,
                'updated_at' => $dish->updated_at,
            ];
        });

        return response()->json([
            'data' => $mappedDishes,
            'meta' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'last_page' => (int) ceil($total / $perPage),
            ]
        ]);
    }

    /**
     * Update a dish owned by the current user (only before approval).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Dish $dish): JsonResponse
    {
        // Only the owner can update
        if ($dish->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Can only edit pending dishes
        if ($dish->status !== self::STATUS_PENDING) {
            return response()->json(['error' => 'Only pending dishes can be edited'], 400);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'comment' => 'nullable|string|max:1000',
            'meal_cost' => 'nullable|numeric|min:0',
            'good_date_spot' => 'nullable|boolean',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:50',
            'reservation' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'set_main_image_id' => 'nullable|integer',
        ]);

        $dish->update(collect($validated)->except(['images', 'remove_images', 'categories', 'set_main_image_id'])->toArray());

        // Sync categories to restaurant if provided
        if ($request->has('categories') && $dish->restaurant) {
            $dish->restaurant->categories()->syncWithoutDetaching($request->input('categories'));
        }

        // Set main image if specified
        if ($request->has('set_main_image_id')) {
            $mainImageId = $request->input('set_main_image_id');
            // Reset all images to not primary
            DishImage::where('dish_id', $dish->id)->update(['is_primary' => false]);
            // Set the specified image as primary
            DishImage::where('dish_id', $dish->id)
                ->where('id', $mainImageId)
                ->update(['is_primary' => true]);
        }

        // Remove images if requested
        if ($request->has('remove_images')) {
            $imagesToRemove = DishImage::where('dish_id', $dish->id)
                ->whereIn('id', $request->input('remove_images'))
                ->get();
            
            foreach ($imagesToRemove as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            // Get image resize settings from admin settings
            $imageWidth = null;
            $imageHeight = null;
            $widthSetting = AdminSetting::where('key', 'image_width')->first();
            $heightSetting = AdminSetting::where('key', 'image_height')->first();
            if ($widthSetting && $widthSetting->value) {
                $imageWidth = (int) $widthSetting->value;
            }
            if ($heightSetting && $heightSetting->value) {
                $imageHeight = (int) $heightSetting->value;
            }
            
            foreach ($request->file('images') as $image) {
                // Resize image if settings are provided
                if ($imageWidth && $imageHeight) {
                    $imageContent = file_get_contents($image->getRealPath());
                    $srcImage = imagecreatefromstring($imageContent);
                    if ($srcImage) {
                        $srcWidth = imagesx($srcImage);
                        $srcHeight = imagesy($srcImage);
                        
                        // Calculate new dimensions maintaining aspect ratio
                        $ratio = min($imageWidth / $srcWidth, $imageHeight / $srcHeight);
                        $newWidth = (int) ($srcWidth * $ratio);
                        $newHeight = (int) ($srcHeight * $ratio);
                        
                        // Create resized image
                        $dstImage = imagecreatetruecolor($newWidth, $newHeight);
                        imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
                        
                        // Save to temp file
                        $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.jpg';
                        imagejpeg($dstImage, $tempPath, 90);
                        imagedestroy($srcImage);
                        imagedestroy($dstImage);
                        
                        // Store resized image
                        $path = Storage::disk('public')->putFile('dishes', new File($tempPath));
                        unlink($tempPath);
                    } else {
                        $path = $image->store('dishes', 'public');
                    }
                } else {
                    $path = $image->store('dishes', 'public');
                }
                
                DishImage::create([
                    'dish_id' => $dish->id,
                    'path' => $path,
                ]);
            }
        }

        return response()->json($dish->load(['restaurant.categories', 'images']));
    }

    /**
     * Delete a dish owned by the current user (only before approval).
     *
     * @param  \App\Models\Dish  $dish
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Dish $dish): JsonResponse
    {
        // Only the owner can delete
        if ($dish->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Can only delete pending dishes
        if ($dish->status !== self::STATUS_PENDING) {
            return response()->json(['error' => 'Only pending dishes can be deleted'], 400);
        }

        $dish->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Store a new dish.
     *
     * Creates a dish with associated restaurant and images.
     * Sends notification emails to user and admin.
     *
     * @param  \App\Http\Requests\StoreDishRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDishRequest $request): JsonResponse
    {
        $dish = DB::transaction(function () use ($request): Dish {
            $restaurantId = $request->integer('restaurant_id');
            
            // If no restaurant_id, create a new restaurant
            if (!$restaurantId && $request->filled('restaurant_name')) {
                $restaurantName = $request->string('restaurant_name')->toString();
                $city = $request->string('restaurant_city')->toString();
                $state = $request->string('restaurant_state')->toString();
                $postcode = $request->string('restaurant_postcode')->toString();
                
                // Check if restaurant already exists with same name, city, and postcode (if provided)
                $query = Restaurant::query()
                    ->where('name', $restaurantName)
                    ->where('city', $city);
                
                if ($postcode) {
                    $query->where('postcode', $postcode);
                }
                
                $existingRestaurant = $query->first();
                
                if ($existingRestaurant) {
                    $restaurantId = $existingRestaurant->id;
                } else {
                    // Create new restaurant (not approved until dish is approved)
                    $restaurant = Restaurant::query()->create([
                        'name' => $restaurantName,
                        'city' => $city,
                        'region' => $state,
                        'postcode' => $postcode,
                        'address' => $request->string('restaurant_address')->toString() ?: '',
                        'country' => $request->string('restaurant_country')->toString() ?: 'United States',
                        'is_approved' => false,
                    ]);
                    $restaurantId = $restaurant->id;
                }
            }
            
            $dish = Dish::query()->create([
                'restaurant_id' => $restaurantId,
                'user_id' => $request->user()->id,
                'name' => $request->string('name')->toString(),
                'comment' => $request->string('comment')->toString(),
                'status' => self::STATUS_PENDING,
                'meal_cost' => $request->input('meal_cost'),
                'good_date_spot' => $request->boolean('good_date_spot'),
                'website' => $request->string('website')->toString(),
                'reservation' => $request->boolean('reservation'),
                'phone' => $request->string('phone')->toString(),
            ]);

            // Update restaurant with additional info from dish submission
            $restaurantUpdates = [];
            
            if ($request->boolean('good_date_spot')) {
                $restaurantUpdates['good_date_spot'] = true;
            }
            
            if ($request->filled('website')) {
                $restaurantUpdates['website'] = $request->string('website')->toString();
            }
            
            if ($request->boolean('reservation')) {
                $restaurantUpdates['reservation'] = true;
            }
            
            if ($request->filled('phone')) {
                $restaurantUpdates['phone'] = $request->string('phone')->toString();
            }
            
            if (!empty($restaurantUpdates)) {
                Restaurant::query()->where('id', $restaurantId)->update($restaurantUpdates);
            }

            // Attach categories to restaurant
            if ($request->has('categories')) {
                $categoryIds = $request->input('categories', []);
                $restaurant = Restaurant::find($restaurantId);
                if ($restaurant && !empty($categoryIds)) {
                    $restaurant->categories()->syncWithoutDetaching($categoryIds);
                }
            }

            // Get main image index (default to 0)
            $mainImageIndex = $request->integer('main_image_index', 0);

            // Get image dimensions from admin settings
            $imageWidth = null;
            $imageHeight = null;
            $widthSetting = AdminSetting::where('key', 'image_width')->first();
            $heightSetting = AdminSetting::where('key', 'image_height')->first();
            if ($widthSetting && $widthSetting->value) {
                $imageWidth = (int) $widthSetting->value;
            }
            if ($heightSetting && $heightSetting->value) {
                $imageHeight = (int) $heightSetting->value;
            }

            foreach ($request->file('images', []) as $index => $image) {
                // Store the image
                $path = $image->store('dishes', 'public');
                
                // Resize if dimensions are set
                if ($imageWidth && $imageHeight) {
                    $storagePath = storage_path('app/public/' . $path);
                    if (function_exists('imagecreatefromstring') && file_exists($storagePath)) {
                        $imgData = file_get_contents($storagePath);
                        $src = imagecreatefromstring($imgData);
                        if ($src) {
                            $srcWidth = imagesx($src);
                            $srcHeight = imagesy($src);
                            
                            // Calculate resize dimensions maintaining aspect ratio
                            $ratio = min($imageWidth / $srcWidth, $imageHeight / $srcHeight);
                            $newWidth = (int) ($srcWidth * $ratio);
                            $newHeight = (int) ($srcHeight * $ratio);
                            
                            $dst = imagecreatetruecolor($newWidth, $newHeight);
                            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
                            
                            // Save based on original extension
                            $ext = strtolower($image->getClientOriginalExtension());
                            if ($ext === 'png') {
                                imagepng($dst, $storagePath);
                            } elseif ($ext === 'gif') {
                                imagegif($dst, $storagePath);
                            } else {
                                imagejpeg($dst, $storagePath, 90);
                            }
                            
                            imagedestroy($src);
                            imagedestroy($dst);
                        }
                    }
                }
                
                DishImage::query()->create([
                    'dish_id' => $dish->id,
                    'path' => $path,
                    'alt_text' => $dish->name,
                    'is_primary' => $index === $mainImageIndex,
                ]);
            }

            return $dish->load(['restaurant', 'images']);
        });

        // Send email notification to user using MailService
        $user = $request->user();
        MailService::send(new DishSubmittedMail($dish, $user), $user->email);

        // Send notification to admin
        $adminEmail = MailService::getAdminNotificationEmail();
        if ($adminEmail) {
            MailService::send(new NewDishSubmittedAdminMail($dish), $adminEmail);
        }

        return response()->json($dish, 201);
    }

    /**
     * Show a single dish with its details.
     *
     * Only approved dishes are publicly viewable, unless user is the owner.
     *
     * @param  string  $slug  The dish slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $dish = Dish::where('slug', $slug)->first();
        
        if (!$dish) {
            return response()->json(['error' => 'Dish not found'], 404);
        }
        
        // Only approved dishes can be viewed publicly
        // Unless the user is the owner of the dish
        if ($dish->status !== self::STATUS_APPROVED) {
            $isOwner = auth()->check() && auth()->id() === $dish->user_id;
            if (!$isOwner) {
                return response()->json(['error' => 'Dish not found or not yet approved'], 404);
            }
        }
        
        $dish->load([
            'restaurant.categories',
            'images',
            'reviews.user',
            'reactions',
        ]);
        
        $dish->loadCount([
            'reactions as likes_count' => fn ($q) => $q->where('type', 'like'),
            'reactions as dislikes_count' => fn ($q) => $q->where('type', 'dislike'),
        ]);
        
        $dish->loadAvg('reviews', 'rating');
        
        // Add user's reaction if authenticated
        $userReaction = null;
        if (auth()->check()) {
            $userReaction = $dish->reactions()
                ->where('user_id', auth()->id())
                ->first();
        }
        
        $response = $dish->toArray();
        $response['user_reaction'] = $userReaction?->type;

        return response()->json($response);
    }
}
