<script lang="ts">
	import { onMount } from 'svelte';

	let loggedIn: boolean = false;

	// Redirect to login page
	onMount(() => {
		if (!loggedIn) {
			window.location.href = '/letflix/login.php';
		}
	});
</script>

<div class="w-full h-full bg-[#141414]"></div>
