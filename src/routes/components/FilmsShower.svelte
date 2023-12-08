<script lang="ts">
	import { onMount } from 'svelte';
	import type Movie from '../../models/Movie';
	import { FetchDB, GetPosterPath } from '../../Extensions/Fetcher';

	export let sql: string;
	export let sectionTitle: string;
	export let tableName: string;

	let matchedMovies: Movie[] = [];

	// Récupère les films les mieux notés
	const handleProcessRequestion = async () => {
		const tempMatchedMovies: Movie[] = await FetchDB(sql, tableName);

		// Récupère les images des films si elles n'ont pas déjà été récupérées
		await Promise.all(
			tempMatchedMovies.map(async (movie: Movie) => {
				const result = await GetPosterPath(movie.Title, movie.ReleaseDate);
				movie.PosterImg = result || '';
			})
		).then(() => {
			matchedMovies = tempMatchedMovies;
		});
	};
</script>

<section
	class="flex flex-col border-2 border-gray-600 rounded-b-xl h-fit px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
>
	<p class="font-bold">{sectionTitle}</p>
	{#if matchedMovies.length === 0}
		<button
			class="px-4 py-2 bg-green-400 w-32 mt-2 border-2 border-black shadow-lg shadow-black mb-3 hover:bg-orange-400 hover:translate-x-2 hover:scale-110 duration-150"
			on:click={handleProcessRequestion}>Charger...</button
		>
	{:else}
		<div class="flex flex-row overflow-x-auto mt-3 horizontal-scrollbar overflow-y-hidden">
			{#each matchedMovies as movie}
				<div
					class="min-h-[300px] relative duration-150 min-w-[200px] block hover:scale-[1.05] z-20"
				>
					<img alt="Poster du film" src={movie.PosterImg} class="object-cover w-full h-full" />

					<p class="absolute bottom-5 text-white bg-black">{movie.Title}</p>
				</div>
			{/each}
		</div>
	{/if}
</section>
