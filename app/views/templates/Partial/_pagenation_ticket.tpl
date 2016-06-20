<!--
  $left_arrow
  $right_arrow
  $page_ary
  $page_index
  $page_send_file
  $query
-->
<div class="container">
<div class="text-center">
  <ul class="pagination">

    <!-- << -->
    {if isset($left_arrow)}
      <li><a href="{$page_send_file}/{$page_index-1}{$query}">&laquo;</a></li>
    {/if}

    <!-- page nation -->
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

    <!-- >> -->
    {if isset($right_arrow)}
      <li><a href="{$page_send_file}/{$page_index+1}{$query}">&raquo;</a></li>
    {/if}
  </ul>
</div>
</div>
