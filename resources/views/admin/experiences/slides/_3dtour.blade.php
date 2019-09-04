@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => '3dtour',
    'keepAlive' => true,
])
    @php($aic3dModel = $item->AIC3DModel)
    <a17-block-if_3d_model
        name="aic_3d_model"
    />
@endcomponent

@push('vuexStore')
    @php($aic3DModel = $item->AIC3DModel)
    @foreach (['model_url', 'model_id', 'camera_position', 'camera_target', 'annotation_list'] as $name)
        window.STORE.form.fields.push({
            name: "{{ 'aic_3d_model[' . $name . ']' }}",
            value: {!! json_encode($aic3DModel ? $aic3DModel->$name : '') !!}
        })
    @endforeach
@endpush