<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	const dispatcher = createEventDispatcher();

	function handleProcessRequestion(
		event: MouseEvent & { currentTarget: EventTarget & HTMLButtonElement }
	) {
		dispatcher('processRequestion', event.currentTarget);
	}
</script>

<button
	class="px-4 py-2 rounded-lg bg-green-400 w-32 mt-2 border-2 border-black shadow-lg shadow-black mb-3 hover:bg-orange-400 hover:translate-x-2 hover:scale-110 duration-150"
	on:click={handleProcessRequestion}>Charger...</button
>
