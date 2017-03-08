<? echo str_replace("\t",'&nbsp;&nbsp;&nbsp;', nl2br(<<<XYZ
<span style="color:#dcdc78">import</span> java<span style="color:#f0f0f0">.</span>io<span style="color:#f0f0f0">.</span>File<span style="color:#f0f0f0">;</span>
<span style="color:#dcdc78">import</span> java<span style="color:#f0f0f0">.</span>util<span style="color:#f0f0f0">.</span>ArrayList<span style="color:#f0f0f0">;</span>
<span style="color:#dcdc78">import</span> java<span style="color:#f0f0f0">.</span>util<span style="color:#f0f0f0">.</span>HashMap<span style="color:#f0f0f0">;</span>
<span style="color:#dcdc78">import</span> java<span style="color:#f0f0f0">.</span>util<span style="color:#f0f0f0">.</span>Scanner<span style="color:#f0f0f0">;</span>


<span style="color:#dcdc78">public class</span> iPodProblem <span style="color:#f0f0f0">{</span>

	<span style="color:#dcdc78">public static</span> <span style="color:#60f0a8">void</span> <span style="color:#db79aa">main</span><span style="color:#f0f0f0">(</span>String<span style="color:#f0f0f0">[]</span> args<span style="color:#f0f0f0">) {</span>
		<span style="color:#dcdc78">try</span> <span style="color:#f0f0f0">{</span>
			File f <span style="color:#f0f0f0">=</span> <span style="color:#dcdc78">new</span> <span style="color:#db79aa">File</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;input.txt&quot;</span><span style="color:#f0f0f0">);</span>
			Scanner s <span style="color:#f0f0f0">=</span> <span style="color:#dcdc78">new</span> <span style="color:#db79aa">Scanner</span><span style="color:#f0f0f0">(</span>f<span style="color:#f0f0f0">);</span>
			iPod i <span style="color:#f0f0f0">=</span> <span style="color:#dcdc78">new</span> <span style="color:#db79aa">iPod</span><span style="color:#f0f0f0">();</span>
			<span style="color:#dcdc78">while</span> <span style="color:#f0f0f0">(</span>s<span style="color:#f0f0f0">.</span><span style="color:#db79aa">hasNextLine</span><span style="color:#f0f0f0">()) {</span>
				<span style="color:#dcdc78">if</span> <span style="color:#f0f0f0">(!</span>i<span style="color:#f0f0f0">.</span><span style="color:#db79aa">parseCommand</span><span style="color:#f0f0f0">(</span>s<span style="color:#f0f0f0">.</span><span style="color:#db79aa">nextLine</span><span style="color:#f0f0f0">()))</span>
					i <span style="color:#f0f0f0">=</span> <span style="color:#dcdc78">new</span> <span style="color:#db79aa">iPod</span><span style="color:#f0f0f0">();</span>
			<span style="color:#f0f0f0">}</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">catch</span> <span style="color:#f0f0f0">(</span>Exception e<span style="color:#f0f0f0">) {</span>
			e<span style="color:#f0f0f0">.</span><span style="color:#db79aa">printStackTrace</span><span style="color:#f0f0f0">();</span>
		<span style="color:#f0f0f0">}</span>
	<span style="color:#f0f0f0">}</span>
<span style="color:#f0f0f0">}</span>

<span style="color:#dcdc78">class</span> iPod <span style="color:#f0f0f0">{</span>
	String iPodName <span style="color:#f0f0f0">=</span> <span style="color:#92d4ff">&quot;&quot;</span><span style="color:#f0f0f0">;</span>
	HashMap<span style="color:#f0f0f0">&lt;</span>String<span style="color:#f0f0f0">,</span> ArrayList<span style="color:#f0f0f0">&lt;</span>String<span style="color:#f0f0f0">&gt;&gt;</span> playlists <span style="color:#f0f0f0">=</span> <span style="color:#dcdc78">new</span> HashMap<span style="color:#f0f0f0">&lt;</span>String<span style="color:#f0f0f0">,</span> ArrayList<span style="color:#f0f0f0">&lt;</span>String<span style="color:#f0f0f0">&gt;&gt;(</span><span style="color:#92d4ff">10</span><span style="color:#f0f0f0">);</span>

	<span style="color:#dcdc78">public</span> <span style="color:#db79aa">iPod</span><span style="color:#f0f0f0">() {</span>

	<span style="color:#f0f0f0">}</span>

	<span style="color:#dcdc78">public</span> <span style="color:#60f0a8">boolean</span> <span style="color:#db79aa">parseCommand</span><span style="color:#f0f0f0">(</span>String line<span style="color:#f0f0f0">) {</span>
		<span style="color:#dcdc78">if</span> <span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">startsWith</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;IPOD&quot;</span><span style="color:#f0f0f0">)) {</span>
			<span style="color:#dcdc78">this</span><span style="color:#f0f0f0">.</span>iPodName <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">replace</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;IPOD&quot;</span><span style="color:#f0f0f0">,</span> <span style="color:#92d4ff">&quot;&quot;</span><span style="color:#f0f0f0">).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			<span style="color:#dcdc78">return</span> true<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">else if</span> <span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">startsWith</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;TRACK&quot;</span><span style="color:#f0f0f0">)) {</span>
			String playlist <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">substring</span><span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">)+</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">.</span><span style="color:#db79aa">length</span><span style="color:#f0f0f0">()).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			String track <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">substring</span><span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;TRACK&quot;</span><span style="color:#f0f0f0">)+</span><span style="color:#92d4ff">&quot;TRACK&quot;</span><span style="color:#f0f0f0">.</span><span style="color:#db79aa">length</span><span style="color:#f0f0f0">(),</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">)).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			playlists<span style="color:#f0f0f0">.</span><span style="color:#db79aa">get</span><span style="color:#f0f0f0">(</span>playlist<span style="color:#f0f0f0">).</span><span style="color:#db79aa">add</span><span style="color:#f0f0f0">(</span>track<span style="color:#f0f0f0">);</span>
			<span style="color:#dcdc78">return</span> true<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">else if</span> <span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">startsWith</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">)) {</span>
			playlists<span style="color:#f0f0f0">.</span><span style="color:#db79aa">put</span><span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">replace</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">,</span> <span style="color:#92d4ff">&quot;&quot;</span><span style="color:#f0f0f0">).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">(),</span> <span style="color:#dcdc78">new</span> ArrayList<span style="color:#f0f0f0">&lt;</span>String<span style="color:#f0f0f0">&gt;(</span><span style="color:#92d4ff">10</span><span style="color:#f0f0f0">));</span>
			<span style="color:#dcdc78">return</span> true<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">else if</span> <span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">startsWith</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;DELETE&quot;</span><span style="color:#f0f0f0">)) {</span>
			String playlist <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">substring</span><span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">)+</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">.</span><span style="color:#db79aa">length</span><span style="color:#f0f0f0">()).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			String track <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">substring</span><span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;DELETE&quot;</span><span style="color:#f0f0f0">)+</span><span style="color:#92d4ff">&quot;delete&quot;</span><span style="color:#f0f0f0">.</span><span style="color:#db79aa">length</span><span style="color:#f0f0f0">(),</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">indexOf</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAYLIST&quot;</span><span style="color:#f0f0f0">)).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			playlists<span style="color:#f0f0f0">.</span><span style="color:#db79aa">get</span><span style="color:#f0f0f0">(</span>playlist<span style="color:#f0f0f0">).</span><span style="color:#db79aa">remove</span><span style="color:#f0f0f0">(</span>track<span style="color:#f0f0f0">);</span>
			<span style="color:#dcdc78">return</span> true<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">else if</span> <span style="color:#f0f0f0">(</span>line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">startsWith</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAY&quot;</span><span style="color:#f0f0f0">)) {</span>
			String playlist <span style="color:#f0f0f0">=</span> line<span style="color:#f0f0f0">.</span><span style="color:#db79aa">replace</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;PLAY&quot;</span><span style="color:#f0f0f0">,</span> <span style="color:#92d4ff">&quot;&quot;</span><span style="color:#f0f0f0">).</span><span style="color:#db79aa">trim</span><span style="color:#f0f0f0">();</span>
			System<span style="color:#f0f0f0">.</span>out<span style="color:#f0f0f0">.</span><span style="color:#db79aa">println</span><span style="color:#f0f0f0">(</span><span style="color:#92d4ff">&quot;Playing &quot;</span><span style="color:#f0f0f0">+</span>playlist<span style="color:#f0f0f0">+</span><span style="color:#92d4ff">&quot; (&quot;</span><span style="color:#f0f0f0">+</span>playlists<span style="color:#f0f0f0">.</span><span style="color:#db79aa">get</span><span style="color:#f0f0f0">(</span>playlist<span style="color:#f0f0f0">).</span><span style="color:#db79aa">size</span><span style="color:#f0f0f0">()+</span><span style="color:#92d4ff">&quot; Songs)&quot;</span><span style="color:#f0f0f0">);</span>
			<span style="color:#dcdc78">for</span> <span style="color:#f0f0f0">(</span>String track <span style="color:#f0f0f0">:</span> playlists<span style="color:#f0f0f0">.</span><span style="color:#db79aa">get</span><span style="color:#f0f0f0">(</span>playlist<span style="color:#f0f0f0">)) {</span>
				System<span style="color:#f0f0f0">.</span>out<span style="color:#f0f0f0">.</span><span style="color:#db79aa">println</span><span style="color:#f0f0f0">(</span>track<span style="color:#f0f0f0">);</span>
			<span style="color:#f0f0f0">}</span>
			<span style="color:#dcdc78">return</span> true<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span> <span style="color:#dcdc78">else</span> <span style="color:#f0f0f0">{</span>
			<span style="color:#dcdc78">return</span> false<span style="color:#f0f0f0">;</span>
		<span style="color:#f0f0f0">}</span>
	<span style="color:#f0f0f0">}</span>
<span style="color:#f0f0f0">}</span>
XYZ
));
