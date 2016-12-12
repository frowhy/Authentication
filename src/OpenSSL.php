<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2016/12/12
 * Time: 14:16
 */

namespace Frowhy\Authentication;


class OpenSSL
{
    var $public_key;
    var $private_key;

    /**
     * @param $private_key
     *
     * @return $this
     */
    public function setPrivateKey($private_key)
    {
        $this->private_key = $private_key;

        return $this;
    }

    /**
     * @param $public_key
     *
     * @return $this
     */
    public function setPublicKey($public_key)
    {
        $this->public_key = $public_key;

        return $this;
    }

    /**
     * @param $data
     *
     * @return bool|string
     */
    public function encrypt($data)
    {
        if (TRUE === file_exists($this->public_key)) {
            $publicKey = openssl_get_publickey(file_get_contents($this->public_key));
            if (FALSE !== $publicKey) {
                openssl_public_encrypt($data, $encrypted, $publicKey);

                return base64_encode($encrypted);
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function decrypt($data)
    {
        if (TRUE === file_exists($this->private_key)) {
            $encrypted = base64_decode($data);
            openssl_private_decrypt($encrypted, $decrypted, file_get_contents($this->private_key));

            return $decrypted;
        } else {
            return FALSE;
        }
    }
}