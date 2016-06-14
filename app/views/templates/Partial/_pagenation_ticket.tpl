<!-- $page_ary -->
<!-- $page_index -->

<div class="container">
<div class="text-center">
  <ul class="pagination">
    {foreach from=$page_ary item=item}
      {if $page_index == ($item) }
        <li class="disabled"><a href="{$page_send_file}/{$item}">
            {$item}
        </a></li>
      {else}
        <li class="active"><a href="{$page_send_file}/{$item}">
            {$item}
        </a></li>
      {/if}
    {/foreach}
  </ul>
</div>
</div>
