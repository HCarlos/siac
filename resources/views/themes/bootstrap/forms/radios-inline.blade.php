@foreach($radios as $radio)
    <label class="radio-inline">
{{--        {!! Form::radio(--}}
{{--            $radio['name'],--}}
{{--            $radio['value'],--}}
{{--            $radio['selected'],--}}
{{--            ['id' => $radio['id']]--}}
{{--        ) !!}--}}
        <input type="radio" value="{{ $radio['value'] }}" name="{{ $radio['name'] }}" id="{{ $radio['id'] }}" {{ $radio['selected'] }}/>
        {{ $radio['label'] }}
    </label>
@endforeach
