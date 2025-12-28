<template>
  <section class="mx-auto max-w-3xl space-y-10">
    <div class="text-center space-y-4">
      <h1 class="text-2xl font-semibold">Upload a Dish or Drink!</h1>
      <button type="button" class="inline-flex rounded border border-slate-500 px-8 py-2 text-lg">
        Upload
      </button>
    </div>

    <div class="rounded border border-slate-200 bg-white p-6 text-center shadow-sm">
      <h2 class="text-xl font-medium">Answer a few quick questions:</h2>

      <div class="mx-auto mt-6 max-w-xl space-y-6 text-left">
        <label class="flex flex-col gap-2">
          <span class="text-sm font-semibold">What Restaurant Are You At?</span>
          <input class="rounded border border-slate-300 px-3 py-2" value="Kumar's Indian Grill" />
        </label>

        <div class="space-y-2 text-sm text-slate-600">
          <p>Please review the following information we found to see if it is accurate:</p>
          <div class="text-slate-900">
            <p class="font-semibold">Kumar's Indian Grill</p>
            <p>123 Street Name</p>
            <p>Portland, OR 97025</p>
            <p>XXX-XXX-XXXX</p>
            <p>www.XXXX.com</p>
            <p>Cuisine Type: Indian</p>
            <p>Reservations: Yes</p>
            <p>Good Date Spot: Yes</p>
          </div>
        </div>

        <div class="flex flex-col gap-4">
          <button type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">
            Submit
          </button>
          <button type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">
            Update Information
          </button>
        </div>
      </div>
    </div>
  </section>
</template>
