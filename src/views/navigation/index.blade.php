<h2>Navigation</h2>

@foreach($tree as $root)
    @foreach($root->getDescendantsAndSelf() as $node)
    {{ str_repeat('-- ', $node->depth) }} {{ $node->page->title }}: {{ $node->depth }}<br>
    @endforeach
@endforeach