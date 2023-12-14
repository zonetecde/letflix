<script lang="ts">
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import Nombre from '../components/Nombre.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
	import { onMount } from 'svelte';
	import { fade } from 'svelte/transition';

	let showAds = false;
	onMount(() => {
		setTimeout(() => {
			showAds = true;
		}, 7_000);
	});

	let promptShown = false;
	let promptIndex = 1;
	let promptTexts: Record<number, string> = {
		1: 'Etes-vous sûr de vouloir fermer la publicité ?',
		2: 'Attention, cette action est irréversible !',
		3: 'Vous ne pourrez plus jamais voir cette publicité !',
		4: "Vous n'avez pas honte de ne pas vouloir donner vos cheveux ?",
		5: 'Laissez-moi devinez, vous êtes chauve ?',
		6: 'Veuillez activer votre webcam pour continuer'
	};

	function handleButtonAdClick() {
		if (promptIndex == 6) {
			promptShown = false;
			showAds = false;
		} else {
			promptIndex++;
		}
	}
</script>

<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar">
	<PageSwitcher page={3} />

	<Carrousel
		sectionTitle="Les titres des films où Robert De Niro a joué :"
		sql="SELECT titles.* FROM titles, credits where titles.id = credits.id and credits.name = 'Robert De Niro';"
		tableName="titles"
	/>

	<br />
	<Carrousel
		sectionTitle="Les titres des films où Johnny Depp a joué et qui sont interdit au moins de 17 ans :"
		sql="SELECT titles.* FROM titles, credits where titles.id = credits.id and credits.name = 'Johnny Depp' and titles.age_certification = 'R';"
		tableName="titles"
	/>

	<br />

	<Nombre
		sql="SELECT titles.release_year as _count FROM titles, credits where titles.id = credits.id and credits.name = 'Clint Eastwood' and credits.character = 'Harry'
		"
		sectionTitle="L'année de sortie du film où apparait Harry, joué par Clint Eastwood"
	/>

	<br />

	<Carrousel
		sectionTitle="Les titres communs classés par popularité croissante entre Titles et TopRatedMovies :"
		sql="SELECT topratedmovies.* FROM titles, topratedmovies where titles.title = topratedmovies.title order by topratedmovies.popularity limit 10;"
		tableName="topratedmovies"
	/>

	{#if showAds}
		<div class="absolute w-full h-full left-0 top-0 flex items-center justify-center">
			<div transition:fade class=" w-[500px] h-[600px] relative mt-20 flex flex-col">
				<!-- Close -->
				<button
					class="absolute top-0 right-0 px-2 py-2 bg-red-500 rounded-bl-xl text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
					on:click={() => {
						// prompt
						promptShown = true;
						promptIndex = 1;
					}}>X</button
				>

				<img src="ad3.png" alt="Publicité" class=" object-contain border-4 border-white" />

				{#if promptShown}
					<div
						class="w-10/12 h-[150px] p-4 text-xl absolute top-1/2 -translate-y-1/2 self-center bg-white bg-opacity-80 text-center"
					>
						<p>{promptTexts[promptIndex]}</p>

						<div class="flex-row gap-x-4 flex items-center justify-center mt-5">
							<button
								class="bg-red-400 px-3 py-1.5 border-2 border-red-600"
								on:click={handleButtonAdClick}>Non</button
							>
							<button
								class="bg-green-400 px-3 py-1.5 border-2 border-green-600"
								on:click={handleButtonAdClick}>Oui</button
							>
						</div>
					</div>
				{/if}
			</div>
		</div>
	{/if}
</div>
