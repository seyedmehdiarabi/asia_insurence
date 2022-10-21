<?php $color = $data->status == -1 ? 'red' : 'black' ?>
<v-tooltip bottom>
    <template v-slot:activator="{on,attrs}">
        <a class="router-link" href="{{ $url }}">
            <v-icon
                color="<?= $color ?>"
                v-bind="attrs"
                v-on="on"
            >
                mdi-eye-outline
            </v-icon>
        </a>
    </template>

    <span>محتوای پیام</span>
</v-tooltip>

