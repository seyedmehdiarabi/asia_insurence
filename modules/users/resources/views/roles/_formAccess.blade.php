<form method="POST">
    @csrf
    <ul class="access" style="padding: 0!important;">
        @foreach ($AccessList as $key=>$item)
            <li class="item_groups">
                <span style="font-weight: bold">{{ $item['label'] }}</span>
                <ul class="d-flex mt-2">
                    @foreach ($item['access'] as $key2=>$value2)
                        <li class="mx-4">
                            <input type="checkbox" @if(CheckAccess($role_accesses,$key,$key2)) checked="checked" @endif name="access[{{ $key }}][]" value="{{ $key2 }}">
                            {{ $value2['label'] }}
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    <div class="form-group">
        <button>
            <v-btn
                class="mt-4"
                color="success"
            >
                ثبت
            </v-btn></button>
    </div>

</form>

