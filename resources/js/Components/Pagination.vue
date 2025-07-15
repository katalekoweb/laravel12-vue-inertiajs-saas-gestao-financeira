<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap -mb-1">
      <template v-for="(link, key) in links">
        <div v-if="link.url === null" :key="key" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded" v-html="link.label" />
        <Link v-else="link.url" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-white': link.active }" :href="link.url" v-html="link.label" />
      </template>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  links: {
    type: Array,
    required: true
  }
})

const formatLabel = (label) => {
  if (label === '&laquo; Previous') return '«'
  if (label === 'Next &raquo;') return '»'
  return label
}

onMounted (() => {
    console.log(props.links);    
})
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}
.pagination-list {
  display: flex;
  list-style: none;
  gap: 0.5rem;
}
.pagination-link {
  padding: 0.5rem 0.75rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  text-decoration: none;
  color: #333;
}
.pagination-link.active {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}
.pagination-link.disabled {
  pointer-events: none;
  opacity: 0.5;
}
</style>
