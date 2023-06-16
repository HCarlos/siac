@foreach($checkboxes as $checkbox)
    <label class="checkbox-inline">
{{--        {!! Form::checkbox(--}}
{{--            $checkbox['name'],--}}
{{--            $checkbox['value'],--}}
{{--            $checkbox['checked'],--}}
{{--            ['id' => $checkbox['id']]--}}
{{--        ) !!}--}}
        <input type="checkbox" value="{{ $checkbox['value'] }}" name="{{ $checkbox['name'] }}" id="{{ $checkbox['id'] }}" {{ $checkbox['checked'] }}/>
        {{ $checkbox['label'] }}
    </label>
@endforeach
