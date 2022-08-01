<?php

namespace scap_graphql\libraries;

class loader {
	public static function load(){
		$fields = field_list::get_field_list();
		$field_prefix = field_list::get_field_prefix();

		if(empty($fields))
			return;

		$field_object_data = [];

		foreach($fields as $field){
			$cleaned_field_name = str_replace($field_prefix, '', $field->slug);;

			$field_object_data[$cleaned_field_name] = [
				'type' => 'string',
				'description' => __(
					$field->description
				),
				'resolve' => function($user, $args, $context, $info){
					return \scap_graphql\libraries\resolver::resolve_field($user, $info->fieldName);
				}
			];
		}

		$config = [
			'description' => __(
				'Available custom meta tags for a user as configured by Simple Custom Author Profiles plugin.'
			),
			'fields' => $field_object_data,
		];

		register_graphql_object_type('SCAPAuthorFields', $config);

		register_graphql_field('User', 'CustomAuthorProfileFields', [
			'type' => 'SCAPAuthorFields',
			'description' => __(
				'Available custom meta tags for a user as configured by Simple Custom Author Profiles plugin.'
			),
			'resolve' => function ($user){
				return $user;
			}
		]);
	}
}