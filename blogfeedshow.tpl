</div>

<div class="divider-blog"><br/></div>

<div id="blog_title"><span>Blog</span> del Mercader</div></div>
<div id="blog_subtitle">&Uacute;ltimas tendencias de la Provincia</div>
<div id="blog_link"><a href="{$link->getPageLink('blogfeedshow', true)}">Entrar >></a></div>

<div id="blog">
	<div id="blog_left">
		{foreach from=$entries item=entry}
			{if $entry['image']}
				<div class="blog_image">
					<a target="_blank" href="{$entry['link']}"><img src="{$entry['image']}" /></a>
				</div>
				<div class="blog_date">
					<span>{$entry['day']}</span><br/>
					{$entry['month']}<br/>
					{$entry['year']}<br/>
				</div>
				<div class="blog_info">
					<div class="blog_title">
						<a target="_blank" href="{$entry['link']}">{$entry['title']}</a>
					</div>
					<div class="blog_subtitle">

					</div>
					<div class="blog_description">
						{$entry['description']|strip_tags:'UTF-8'|truncate:200:'...'}
					</div>
				</div>
			{/if}
		{/foreach}
	</div>
	<div id="blog_right">
		{foreach from=$entries item=entry}
			{if $entry['image'] == ''}
				<div class="blog_entry{if $entry['id'] == $entries|@count} last{/if}">
					<div class="blog_date">
						<span>{$entry['day']}</span><br/>
						{$entry['month']}<br/>
						{$entry['year']}<br/>
					</div>
					<div class="blog_info">
						<div class="blog_title">
							<a target="_blank" href="{$entry['link']}">{$entry['title']}</a>
						</div>
						<div class="blog_subtitle">

						</div>
						<div class="blog_description">
							{$entry['description']|strip_tags:'UTF-8'|truncate:125:'...'}
						</div>
					</div>
					<div style="clear:both;"><br/></div>
				</div>
			{/if}
		{/foreach}	
	</div>
	<div style="clear:both;"><br/></div>
</div>

<div>