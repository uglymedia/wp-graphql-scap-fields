<?php

namespace scap_graphql\libraries;

class resolver {
	public static function resolve_field(\WPGraphQL\Model\User $user, string $field_name){
		if(!field_list::is_valid_field($field_name))
			return null;

		$field_name = field_list::get_field_prefix() . str_replace(field_list::get_field_prefix(), '', $field_name);

		return get_user_meta($user->databaseId, $field_name, true);
	}
}