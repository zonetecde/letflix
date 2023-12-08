<script lang="ts">
	import { onMount } from 'svelte';
	import type Movie from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';
	import ShowButton from './ShowButton.svelte';

	export let sql: string;
	export let sectionTitle: string;
	export let tableName: string;

	let texts: string[] = [];

	// Récupère les films les mieux notés
	const handleProcessRequestion = async () => {
		const tempTexts: [] = await FetchDB(sql, tableName);

		tempTexts.forEach((movie: any) => {
			texts = [...texts, movie._text];
		});
	};
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if texts.length === 0}
		<ShowButton on:processRequestion={handleProcessRequestion} />
	{:else}
		<div
			class="flex flex-row overflow-x-auto mt-3 horizontal-scrollbar overflow-y-hidden gap-x-2 pb-2"
		>
			{#each texts as text}
				<div
					class="min-h-[150px] relative duration-150 min-w-[150px] hover:scale-[1.02] bg-orange-300 flex items-center justify-center rounded-2xl border-4 border-orange-500"
				>
					<p class="font-bold text-xl px-5">{text}</p>
				</div>
			{/each}
		</div>
	{/if}
</section>
