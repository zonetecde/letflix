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

	function randomBrightColor() {
		var r = Math.floor(Math.random() * 156) + 100;
		var g = Math.floor(Math.random() * 156) + 100;
		var b = Math.floor(Math.random() * 156) + 100;
		const color = '#' + ('000000' + rgbToHex(r, g, b)).slice(-6);

		return color;
	}

	function rgbToHex(r: number, g: number, b: number) {
		return ((r << 16) | (g << 8) | b).toString(16);
	}
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800 overflow-x-auto horizontal-scrollbar overflow-y-hidden"
>
	<p class="font-bold">{@html sectionTitle}</p>
	{#if texts.length === 0}
		<ShowButton on:processRequestion={handleProcessRequestion} {sql} />
	{:else}
		<div class="flex flex-row mt-3 gap-x-2 pb-2">
			{#each texts as text}
				<div
					class="min-h-[150px] duration-150 min-w-[150px] hover:scale-[1.10] flex items-center justify-center rounded-2xl border-4 relative border-orange-500"
					style={'background-color: ' + randomBrightColor() + ' ;'}
				>
					<img src="dots.png" alt="dots" class="absolute inset-0 opacity-[0.15]" />
					<p class="font-bold text-xl px-5">{text}</p>
				</div>
			{/each}
		</div>
	{/if}
</section>
