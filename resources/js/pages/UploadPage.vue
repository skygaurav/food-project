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
            <input v-model="form.restaurant" class="rounded border border-slate-300 px-3 py-2" />
          </label>

          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Meal cost</span>
            <input v-model="form.meal_cost" type="number" step="0.01" class="rounded border border-slate-300 px-3 py-2" />
          </label>

          <label class="flex items-center gap-3">
            <input type="checkbox" v-model="form.good_date_spot" />
            <span class="text-sm">Good date spot</span>
          </label>

          <label class="flex flex-col gap-2">
            <span class="text-sm font-semibold">Website</span>
            <input v-model="form.website" type="url" class="rounded border border-slate-300 px-3 py-2" />
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
          <button @click="submit" type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">Submit</button>
          <button type="button" class="rounded border border-slate-500 px-6 py-2 text-lg">Update Information</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({ restaurant:'', meal_cost:'', good_date_spot:false, website:'', images: [] });

async function submit(){
  const fd = new FormData();
  // restaurant_id requires selecting existing restaurant; placeholder 1
  fd.append('restaurant_id', 1);
  fd.append('name', 'Uploaded dish');
  fd.append('comment', 'Submitted via frontend');
  if(form.value.meal_cost) fd.append('meal_cost', form.value.meal_cost);
  fd.append('good_date_spot', form.value.good_date_spot ? '1' : '0');
  if(form.value.website) fd.append('website', form.value.website);
  // images omitted in this simple example

  try{
    const res = await fetch('/api/dishes', { method: 'POST', credentials: 'same-origin', body: fd });
    if(!res.ok) throw new Error('failed');
    alert('Submitted');
  }catch(e){ alert('Submit failed'); }
}
</script>
