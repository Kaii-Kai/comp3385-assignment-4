<script setup>

</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">COMP3385</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/'}" to="/">Home</RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/about'}" to="/about">About</RouterLink>
                    </li>
					<li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies/create'}" to="/movies/create">Add Movie</RouterLink>
                    </li>
					<li class="nav-item">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/movies'}" to="/movies">Movies</RouterLink>
                    </li>
					<li class="nav-item"> v-if="!isLoggedIn">
                        <RouterLink class="nav-link" :class="{ active: $route.path === '/login'}" to="/login">Login</RouterLink>
                    </li>
					<li class="nav-item"> v-if="isLoggedIn">
                        <button class="nav-link btn btn-link" @click="logout">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { RouterLink, useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

const isLoggedIn = ref(false);
const router = useRouter();

onMounted(() => {
	isLoggedIn.value = !!localStorage.getItem('access_token');
});

const logout = () => {
	const token = localStorage.getItem('access_token');
	fetch('/api/v1/logout', {
		method: 'POST',
		headers: {
			'Authorization': `Bearer ${token}`,
			'Accept': 'application/json',
    },
  })
    .then((response) => {
		if (response.ok) {
			localStorage.removeItem('access_token');
			isLoggedIn.value = false;
			router.push('/login'); 
		} else {
			console.error('Logout failed');
		}
    })
    .catch((error) => {
      console.error('Error during logout:', error);
    });
};
</script>

<style scoped>

</style>
