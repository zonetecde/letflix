<script>
	import '../app.css';
</script>

<div class="h-screen w-screen">
	<nav
		class="bg-[#512727] h-12 md:h-20 flex flex-row relative items-center px-5 border-b-2 border-red-800 outline-b"
	>
		<div
			class="absolute left-0 right-0 px-10 py-1 h-full flex flex-row items-center justify-center gap-4 bg-gradient-to-r from-[#c3adc500] via-[#ae2833] to-[#c3adc500]"
		>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
			<img
				src="letflix-white.png"
				alt="Logo du site"
				class="h-full object-contain cursor-pointer"
				on:click={() => window.location.reload()}
			/>
			<!-- svelte-ignore a11y-click-events-have-key-events -->
			<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
			<img
				src="github.png"
				alt="GitHub logo"
				class="absolute opacity-60 right-2 w-8 md:w-24 cursor-pointer"
				on:click={() => window.open('https://github.com/zonetecde/letflix')}
			/>
		</div>
	</nav>

	<div class="h-full -mt-12 pt-12 md:-mt-20 md:pt-20">
		<slot />
	</div>
</div>
