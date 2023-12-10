<script lang="ts">
	import { onMount } from 'svelte';
	import Carrousel from './components/FilmsShower.svelte';
	import Login from './components/Login.svelte';
	import Nombre from './components/Nombre.svelte';
	import Resume from './components/Resume.svelte';
	import TextShower from './components/TextShower.svelte';

	let loggedIn: boolean = false;

	// Redirect to login page
	onMount(() => {
		if (!loggedIn) {
			window.location.href = '/login';
		}
	});
</script>

<div class="w-full h-full bg-[#141414]"></div>
