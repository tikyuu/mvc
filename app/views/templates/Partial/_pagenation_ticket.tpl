<!--
  $page_ary
  $page_index
  $page_send_file
-->
<div class="container">
<div class="text-center">
  <ul class="pagination">
    {foreach from=$page_ary item=item}
      {if $page_index == ($item) }
        <li class="disabled"><a href="{$page_send_file}/{$item}{$query}">
            {$item}
        </a></li>
      {else}
        <li class="active"><a href="{$page_send_file}/{$item}{$query}">
            {$item}
        </a></li>
      {/if}
    {/foreach}
  </ul>
</div>
</div>
