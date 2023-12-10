<script>
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import Nombre from '../components/Nombre.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
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
</div>
