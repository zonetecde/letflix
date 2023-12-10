<script>
	import Resume from '../components/Resume.svelte';
	import TextShower from '../components/TextShower.svelte';
	import Carrousel from '../components/FilmsShower.svelte';
	import PageSwitcher from '../components/PageSwitcher.svelte';
</script>

<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar">
	<PageSwitcher page={1} />

	<Carrousel
		sql="SELECT * FROM 'topratedmovies' where title like 'Star Wars%';"
		sectionTitle="Nos films Star Wars"
		tableName="topratedmovies"
	/>
	<br />

	<Carrousel
		sql="SELECT * FROM 'bestmoviesnetflix' where RELEASE_YEAR < 2000 and score > 8.0;"
		sectionTitle="Les films avant 2000 avec un score supérieur à 8/10"
		tableName="bestmoviesnetflix"
	/>

	<br />

	<TextShower
		sectionTitle="Tout les genres parmis les meilleurs séries... <sm class='text-sm italic'>(puisque j'ai fait un joli carrousel je n'ai pas limité les résultats à 10)</sm> :"
		sql="SELECT DISTINCT MAIN_GENRE as _text FROM 'bestshowsnetflix'; -- LIMIT 10"
		tableName="text"
	/>

	<br />

	<Resume
		sql="SELECT * FROM 'topratedmovies' where Title like '%Spider-Man%' ORDER BY VoteAverage desc LIMIT 1;"
		sectionTitle="La description du film Spider-Man le mieux noté :"
		tableName="topratedmovies"
	/>
</div>
