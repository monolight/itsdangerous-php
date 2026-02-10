<?php

namespace ItsDangerous\Signer;

class SimpleJsonSerializer {

    public function loads($input) {
        return json_decode((string) $input, true);
    }

    public function dumps($input) {
        return json_encode($input);
    }

}
