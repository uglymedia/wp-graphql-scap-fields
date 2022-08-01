SCAP WP Graph QL Connector Plugin
==================================

This plugin exposes SCAP fields to the WP Graph QL plugin for the purposes of querying those fields.

## The SCAP Object
For every user query there will be an associated SCAP object containing fields, this object is called `customAuthorProfileFields`. The SCAP object will be automatically populated with the available SCAP fields that have been configured through the SCAP plugin.

The SCAP object will expose the fields as they are configured in the admin UI, meaning they will be exposed in the object without their SCAP field prefix.

The default SCAP field prefix is `um_cap_`, this prefix is used to provide uniqueness in the database. However, when using the SCAP GraphQL object you MUST omit this prefix as the fields are exposed without it.

For example, given set of SCAP fields, as they are saved in the wp_usermeta table:
- um_cap_twitter_handle
- um_cap_facebook_id
- um_cap_instagram_handle

The following would be the appropriate notation for the SCAP Graph QL object:
    customAuthorProfileFields {
        twitter_handle
        facebook_id
        instagram_handle
    }

*NOTE: If you exclusively use the SCAP admin UI to configure your custom fields you do not need to worry about field prefixes. Simply refer to the `slug` field as it is displayed in the admin UI, this will be exactly what is exposed in the Graph QL SCAP object*

## Examples

#### Query a list of users and include the SCAP field twitter_handle
    query NewQuery {
        users {
            nodes {
                customAuthorProfileFields {
                    twitter_handle
                }
                databaseId
            }
        }
    }

#### Query a list of posts including the author of the post, and include the SCAP field twitter_handle
    query NewQuery {
        posts {
            nodes {
                author {
                    node {
                        customAuthorProfileFields {
                            twitter_handle
                        }
                        userId
                    }
                }
                postId
                slug
                title
            }
        }
    }

#### Query a specific post including the author of the post, and include the SCAP field twitter_handle
    query NewQuery {
        post(id: "1", idType: DATABASE_ID) {
            author {
                node {
                    customAuthorProfileFields {
                        twitter_handle
                    }
                    userId
                }
            }
            postId
            slug
            title
        }
    }