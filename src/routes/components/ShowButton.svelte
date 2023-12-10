<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	const dispatcher = createEventDispatcher();
	export let sql: string;

	function handleProcessRequestion(
		event: MouseEvent & { currentTarget: EventTarget & HTMLButtonElement }
	) {
		dispatcher('processRequestion', event.currentTarget);
	}
</script>

<div class="flex flex-row items-center">
	<button
		class="px-4 py-2 rounded-lg bg-green-400 w-32 mt-2 border-2 border-black shadow-lg shadow-black mb-3 hover:bg-orange-400 hover:translate-x-2 hover:scale-110 duration-150 button"
		on:click={handleProcessRequestion}>Charger...</button
	>

	<code class="bg-white ml-9 px-3 rounded-lg opacity-0 hidden-text duration-200">{sql}</code>
</div>

<style>
	.button:hover + .hidden-text {
		opacity: 1;
	}
</style>
