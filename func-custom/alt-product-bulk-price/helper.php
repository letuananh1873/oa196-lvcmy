<?php
if( ! function_exists('bulk_price_attributes') ) {
    function bulk_price_attributes() {
        $data = [
            [
                'casing' => 'double-pave',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'double-plain',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'straight-pave',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'straight-plain',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'tapered-pave',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'tapered-plain',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'twirl-pave',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'twirl-plain',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'twisted-pave',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'twisted-plain',
                'diamond-type' => 'none'
            ],
            [
                'casing' => 'double-pave',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'double-plain',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'straight-pave',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'straight-plain',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'tapered-pave',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'tapered-plain',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'twirl-pave',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'twirl-plain',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'twisted-pave',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'twisted-plain',
                'diamond-type' => 'halo'
            ],
            [
                'casing' => 'double-pave',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'double-plain',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'straight-pave',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'straight-plain',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'tapered-pave',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'tapered-plain',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'twirl-pave',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'twirl-plain',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'twisted-pave',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'twisted-plain',
                'diamond-type' => '6-prong'
            ],
            [
                'casing' => 'double-pave',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'double-plain',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'straight-pave',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'straight-plain',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'tapered-pave',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'tapered-plain',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'twirl-pave',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'twirl-plain',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'twisted-pave',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'twisted-plain',
                'diamond-type' => '4-prong-square'
            ],
            [
                'casing' => 'double-pave',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'double-plain',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'straight-pave',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'straight-plain',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'tapered-pave',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'tapered-plain',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'twirl-pave',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'twirl-plain',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'twisted-pave',
                'diamond-type' => '4-prong-nsew'
            ],
            [
                'casing' => 'twisted-plain',
                'diamond-type' => '4-prong-nsew'
            ]
        ];
        

        return $data;
    }
}


function bulk_price_string_attributes() {
    $data = [];

    $i = 0;
    foreach( bulk_price_attributes() as $key => $attribute ) {
        $data[$key] = implode(',', $attribute);

        $i++;
    }

    return $data;
}

function bulk_price_col_attributes() {
    $data = [];

    $i = 0;
    foreach( bulk_price_attributes() as $key => $attribute ) {
        $data[$key] = 'attribute_' . $key;

        $i++;
    }

    return $data;
}