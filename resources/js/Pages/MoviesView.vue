<template>
	<h1>Movies</h1>
	<div v-if="movies.length === 0">
		<p>No movies to display.</p>
	</div>
	<div v-else>
		<div v-for="movie in movies" :key="movie.id">
			<h2>{{ movie.title }}</h2>
			<p>{{ movie.description }}</p>
			<img v-if="movie.poster" :src="'/storage/' + movie.poster" alt="Movie Poster" />
			<hr>
		</div>
	</div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

let movies = ref([]);

const fetchMovies = async () => {
	const token = localStorage.getItem('access_token');
	try {
		const response = await fetch('/api/v1/movies'), {
			headers: {
				'Authorization': `Bearer ${token}`,
				'Accept': 'application/json'
			}
		});
		
		if (!response.ok) {
			throw new Error('Could not fetch movies');
		}
		
		const data = await response.json();
		movies.value = data.movies;

	} catch (error) {
		console.error('Error fetching movies:', error);
	}
};

onMounted(() => {
	fetchMovies();
});
</script>