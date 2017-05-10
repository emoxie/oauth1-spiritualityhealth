<?php

	namespace Emoxie\OAuth1\Client\Server;

	use League\Oauth1\Client\Credentials\TokenCredentials;
	use League\OAuth1\Client\Server\Server;
	use League\OAuth1\Client\Server\User;

	class SpiritualityHealth extends Server {

		const API_URL = "https://store.spiritualityhealth.com";

		/**
		 * Get the URL for retrieving temporary credentials.
		 *
		 * @return string
		 */
		public function urlTemporaryCredentials() {
			return self::API_URL . '/oauth1/provider/request_token';
		}

		/**
		 * Get the URL for redirecting the resource owner to authorize the client.
		 *
		 * @return string
		 */
		public function urlAuthorization() {
			return self::API_URL . '/oauth1/provider/authorize';
		}

		/**
		 * Get the URL retrieving token credentials.
		 *
		 * @return string
		 */
		public function urlTokenCredentials() {
			return self::API_URL . '/oauth1/provider/access_token';
		}

		/**
		 * Get the URL for retrieving user details.
		 *
		 * @return string
		 */
		public function urlUserDetails() {
			return self::API_URL . "/me/company";
		}

		/**
		 * Take the decoded data from the user details URL and convert
		 * it to a User object.
		 *
		 * @param mixed            $data
		 * @param TokenCredentials $tokenCredentials
		 *
		 * @return User
		 */
		public function userDetails( $data, TokenCredentials $tokenCredentials ) {
			$user = new User;

			$arraySearchAndDestroy = function ( array &$array, $key ) {
				if ( ! array_key_exists( $key, $array ) ) {
					return null;
				}

				$value = $array[ $key ];
				unset( $array[ $key ] );

				return $value;
			};

			$user->uid         = $arraySearchAndDestroy( $data, 'customer_id' );
			$user->nickname    = $arraySearchAndDestroy( $data, 'fname' );
			$user->firstName   = $arraySearchAndDestroy( $data, 'fname' );
			$user->lastName    = $arraySearchAndDestroy( $data, 'lname' );
			$user->name        = $user->firstName . ' ' . $user->lastName;
			$user->email       = $arraySearchAndDestroy( $data, 'email' );
			$user->location    = [
				'city'    => '',
				'state'   => '',
				'country' => '',
			];
			$user->description = '';
			$user->imageUrl    = '';
			$user->urls        = '';
			$user->extra       = (array) $data;

			return $user;
		}

		/**
		 * Take the decoded data from the user details URL and extract
		 * the user's UID.
		 *
		 * @param mixed            $data
		 * @param TokenCredentials $tokenCredentials
		 *
		 * @return string|int
		 */
		public function userUid( $data, TokenCredentials $tokenCredentials ) {
			return $data['customer_id'];
		}

		/**
		 * Take the decoded data from the user details URL and extract
		 * the user's email.
		 *
		 * @param mixed            $data
		 * @param TokenCredentials $tokenCredentials
		 *
		 * @return string
		 */
		public function userEmail( $data, TokenCredentials $tokenCredentials ) {
			return $data['email'];
		}

		/**
		 * Take the decoded data from the user details URL and extract
		 * the user's screen name.
		 *
		 * @param mixed            $data
		 * @param TokenCredentials $tokenCredentials
		 *
		 * @return string
		 */
		public function userScreenName( $data, TokenCredentials $tokenCredentials ) {
			return $data['fname'];
		}
	}
