@foreach($checkboxes as $checkbox)
    <div class="checkbox">
        <label>
{{--            {!! Form::checkbox(--}}
{{--                $checkbox['name'],--}}
{{--                $checkbox['value'],--}}
{{--                $checkbox['checked'],--}}
{{--                ['id' => $checkbox['id']]--}}
{{--            ) !!}--}}
            <input type="checkbox" value="{{ $checkbox['value'] }}" name="{{ $checkbox['name'] }}" id="{{ $checkbox['id'] }}" {{ $checkbox['checked'] }}/>
            {{ $checkbox['label'] }}
        </label>
    </div>
@endforeach
