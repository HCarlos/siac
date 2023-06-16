@php
    $classes = 'form-check-input';
    if ($hasErrors) {
        $classes .= ' is-invalid';
    }
@endphp
@foreach($checkboxes as $checkbox)
    <div class="form-check">
{{--        {!! Form::checkbox(--}}
{{--            $checkbox['name'],--}}
{{--            $checkbox['value'],--}}
{{--            $checkbox['checked'],--}}
{{--            ['class' => $classes, 'id' => $checkbox['id']]--}}
{{--        ) !!}--}}
        <input type="checkbox" value="{{ $checkbox['value'] }}" name="{{ $checkbox['name'] }}" id="{{ $checkbox['id'] }}" {{ $checkbox['checked'] }} class="{{ $classes }}" />
        <label class="form-check-label" for="{{ $checkbox['id'] }}">
            {{ $checkbox['label'] }}
        </label>
    </div>
@endforeach
