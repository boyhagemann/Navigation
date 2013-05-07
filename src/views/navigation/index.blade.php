<h2>Navigation</h2>

<ul class="unstyled row-fluid">
    @foreach($tree as $root)
    @foreach($root->getDescendantsAndSelf() as $node)
    <li class="offset{{ $node->depth }}">            
        <i class="icon-file muted"></i> <a href="{{ URL::route('cms.pages.content', $node->page->id) }}">{{ $node->page->title }}</a>
    </li>
    @endforeach
    @endforeach
</ul>