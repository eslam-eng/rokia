<div>
    <label for="basic-url" class="form-label" style=" font-weight: bold;">{{$title}}</label>
    <select
        id='users-search-{{$this->getId()}}'
        name="{{$name}}"
        data-placeholder="@lang('app.therapists.therapist')"
        class="form-control form-select-lg js-select2-custom mx-1"
    >
        @foreach ($options as $user)
            <option value="{{ $user->id }}" @selected($selected == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<script>
    document.addEventListener('livewire:init', function () {
        $("#users-search-{{$this->getId()}}").select2({
            ajax: {
                url: "{{ route('users.search') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        keyword: params.term, // search term
                        page: params.page,
                        type:"{{$user_type}}"
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    let results = data.data;
                    return {
                        results: $.map(results, function (result) {
                            return {
                                text: result.name,
                                id: result.id,
                            }
                        }),
                        pagination: {
                            more: (params.page * 10) < data.total
                        }
                    };
                },
                cache: true
            },
            placeholder: "@lang('app.therapists.therapists')",
            minimumInputLength:2,
            language: {
                inputTooShort: function () {
                    return "@lang('app.select2.input_too_short')";
                },
                searching: function () {
                    return "@lang('app.select2.searching')";
                },
                noResults: function () {
                    return "@lang('app.select2.no_results')";
                },
            },
            allowClear: true,
            closeOnSelect: true,
            selectOnClose: true,
        }).on('change', function (e) {
            @this.set('selected', e.target.value);
        });;
    });
</script>
