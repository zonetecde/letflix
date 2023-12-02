<script lang="ts">
	import { onMount } from 'svelte';
	import AppVariables from '../AppVariables';
	import type Movie from '../models/Movie';
	import { FetchDB, GetPosterPath } from '../Extensions/Fetcher';

	let bestMovies: Movie[] = [];

	// Récupère les films les mieux notés
	onMount(async () => {
		const tempBestMovies: Movie[] = await FetchDB(
			'SELECT * FROM topratedmovies ORDER BY VoteAverage desc LIMIT 15'
		);

		// Récupère les images des films si elles n'ont pas déjà été récupérées
		await Promise.all(
			tempBestMovies.map(async (movie: Movie) => {
				const result = await GetPosterPath(movie.Title, movie.ReleaseDate);
				movie.PosterImg = result || '';
			})
		).then(() => {
			bestMovies = tempBestMovies;
		});
	});
</script>

<div class="w-full h-full bg-[#532727] text-black p-4">
	<section
		class="flex flex-col border-2 border-gray-600 rounded-b-xl h-56 px-2 p-1 shadow-xl bg-[#997578] shadow-gray-800"
	>
		<p class="font-bold">Nos films les mieux notés...</p>

		<div class="flex flex-row overflow-x-auto h-full">
			{#each bestMovies as movie}
				<div class="h-full w-52 relative duration-150">
					<img
						alt="Poster du film"
						src={movie.PosterImg}
						class="object-cover w-full h-full absolute inset-0"
					/>
					<p class="font-bold z-10 absolute bg-white bottom-2 left-0 right-0 text-center mx-1">
						{movie.Title}
					</p>
				</div>
			{/each}
		</div>
	</section>
</div>
