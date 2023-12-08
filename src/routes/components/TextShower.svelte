<script lang="ts">
	import { onMount } from 'svelte';
	import type Movie from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';

	export let sql: string;
	export let sectionTitle: string;
	export let tableName: string;

	let texts: string[] = [];

	// Récupère les films les mieux notés
	const handleProcessRequestion = async () => {
		const tempTexts: [] = await FetchDB(sql, tableName);

		tempTexts.forEach((movie: any) => {
			texts = [...texts, movie._TEXT];
		});
	};
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if texts.length === 0}
		<button
			class="px-4 py-2 bg-green-400 w-32 mt-2 border-2 border-black shadow-lg shadow-black mb-3 hover:bg-orange-400 hover:translate-x-2 hover:scale-110 duration-150"
			on:click={handleProcessRequestion}>Charger...</button
		>
	{:else}
		<div class="flex flex-row overflow-x-auto mt-3 horizontal-scrollbar overflow-y-hidden">
			{#each texts as text}
				<div
					class="min-h-[80px] relative duration-150 min-w-[80px] hover:scale-[1.05] z-20 bg-orange-300 flex items-center justify-center"
				>
					<p class="">{text}</p>
				</div>
			{/each}
		</div>
	{/if}
</section>
