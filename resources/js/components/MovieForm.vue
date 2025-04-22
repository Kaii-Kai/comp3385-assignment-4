<template>
	<form id = "movieForm" @submit.prevent="saveMovie">
		<div class="form-group mb-3">
			<label for="title" class="form-label">Movie Title</label>
			<input type="text" name="title" class="form-control" />
    </div>
	
    <div class="form-group mb-3">
		<label for="description" class="form-label">Movie Description</label>
		<textarea id="description" name="description" class="form-control"></textarea>
    </div>
	
    <div class="form-group mb-3">
		<label for="poster" class="form-label">Movie Poster</label>
		<input type="file" name="poster" class="form-control" />
    </div>
	
    <button type="submit" class="btn btn-primary">Save</button>
  </form>
</template>

<script setup>
const saveMovie = () => {
	let movieForm = document.getElementById('movieForm');
	let form_data = new FormData(movieForm);
	const token = localStorage.getItem('access_token');

	try {
		const response = await fetch("/api/v1/movies", {
			method: 'POST',
			body: form_data,
			headers: {
				'Authorization': `Bearer ${token}`, 
				'Accept': 'application/json'
      }
	})
	
	.then(response => {
	if (!response.ok) {
		return response.json().then(errorData => {
        console.error('Error saving movie:', errorData);
        throw errorData;
      });
    }
    return response.json();
	})
  
	.then(data => {
		console.log('Movie saved successfully:', data);
	})
	
	.catch(error => {
		console.error('Error saving movie:', error);
	});
};
</script>