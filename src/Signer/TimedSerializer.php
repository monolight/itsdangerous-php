<?php

namespace ItsDangerous\Signer;

use ItsDangerous\BadData\BadPayload;

class TimedSerializer extends Serializer {

    public $default_signer = \ItsDangerous\Signer\TimestampSigner::class;

    #[\Override]
    public function loads($s, $max_age=null, $return_timestamp=false, $salt=null) {
        [$base64d, $timestamp] = $this->make_signer($salt)->unsign($s, $max_age, true);
        $payload = $this->load_payload($base64d);
        if($return_timestamp) {
            return [$payload, $timestamp];
        } else {
            return $payload;
        }
    }

    #[\Override]
    public function load($f, $max_age=null, $return_timestamp=false, $salt=null) {
        $stats = fstat($f);
        return $this->loads(fread($f, $stats['size']), $max_age, $return_timestamp, $salt);
    }

    #[\Override]
    public function loads_unsafe($s, $max_age=null, $return_timestamp=false, $salt=null) {
        try {
            return [true, $this->loads($s, $max_age, $return_timestamp, $salt)];
        } catch (\Exception $ex) {
            if (empty($ex->payload)) {
                return [false, null];
            }
            try {
                return [false, $this->load_payload($ex->payload)];
            } catch (BadPayload) {
                return [false, null];
            }
        }
    }

    #[\Override]
    public function load_unsafe($f, $max_age=null, $return_timestamp=false, $salt=null) {
        $stats = fstat($f);
        return $this->loads_unsafe(fread($f, $stats['size']), $max_age, $return_timestamp, $salt);
    }

}
