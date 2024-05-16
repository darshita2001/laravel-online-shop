<div class="row page-titles ">
    <div class="col d-flex justify-content-start">
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
            <li class="breadcrumb-item"><a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name']}}</a></li>
            @endforeach
        </ol>
    </div>
</div>
