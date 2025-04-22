<template>
	<h1>Login</h1>
	<form @submit.prevent="login">
		<div class="form-group mb-3">
			<label for="email" class="form-label">Email address</label>
			<input type="email" name="email" class="form-control" />
		</div>
		
		<div class="form-group mb-3">
			<label for="password" class="form-label">Password</label>
			<input type="password" name="password" class="form-control" />
		</div>
		
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const router = useRouter();

const login = () => {
	fetch('/api/v1/login', {
		method: 'POST',
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
    },
    body: JSON.stringify({ email: email.value, password: password.value })
  })
	.then(response => {
		if (!response.ok) {
			return response.json().then(errorData => {
				console.error('Login failed:', errorData);
        
			throw errorData;
      });
    }
    return response.json();
  })
	.then(data => {
		console.log('Login successful!', data);
		localStorage.setItem('access_token', data.access_token);

		router.push('/movies');
	})
	.catch(error => {
		console.error('Error during login:', error);
    });
};
</script>