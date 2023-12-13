<script>
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import Nombre from '../components/Nombre.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
	import { modal } from '../../models/Store';

	function handlePublicityCloseButtonClicked() {
		modal.set(
			'Une erreur est survenue lors de la fermeture de la publicité. Veuillez réessayer plus tard.'
		);
		publiciteCount++;
	}

	let publiciteCount = 1;
</script>

<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar grid grid-rows-6">
	<div class="row-span-4">
		<PageSwitcher page={2} />

		<Nombre
			sql="SELECT sum(votecount) as _count FROM 'topratedmovies';
		"
			sectionTitle="Le nombre total de vote dans la table topratedmovies"
		/>

		<br />

		<Nombre
			sql="SELECT count(*) as _count FROM bestshowsnetflix where SEASONS > 5
		"
			sectionTitle="Le nombre de série qui ont plus de 5 saisons"
		/>
		<br />

		<Nombre
			sql="SELECT avg(DURATION) as _count FROM bestmoviesnetflix where DURATION >= (select DURATION from bestmoviesnetflix where TITLE = 'Steve Jobs');
		"
			sectionTitle="La durée moyenne des films qui durent plus longtemps que le film 'Steve Jobs'"
			roundResult={false}
		/>

		<br />

		<Resume
			sql="SELECT * FROM topratedmovies WHERE Title LIKE '%Die Hard%' ORDER BY Popularity LIMIT 1 OFFSET (SELECT COUNT(*) / 2 FROM topratedmovies WHERE Title LIKE '%Die Hard%');"
			sectionTitle="La description du film à la popularité médiane Die Hard"
			tableName="topratedmovies"
		/>
	</div>

	<div class="fixed bottom-2 right-2 border-2 border-gray-400 gap-y-2 flex flex-col">
		{#each Array(publiciteCount) as _}
			<div class="relative">
				<!-- Close button -->
				<button
					class="absolute top-0 right-0 px-2 bg-red-500 rounded-bl-xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
					on:click={handlePublicityCloseButtonClicked}>X</button
				>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
				<img
					src="ad2.png"
					alt="Publicité"
					class="h-40 cursor-pointer object-contain"
					on:click={() => {
						window.open('https://www.travelski.com/');
					}}
				/>
			</div>
		{/each}
	</div>
</div>
