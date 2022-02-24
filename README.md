
# auth0-proxy
![CircleCI](https://img.shields.io/circleci/build/github/chaseconey/auth0-proxy)
![Docker Image Version (latest semver)](https://img.shields.io/docker/v/chaseconey/auth0-proxy)

This is a simple Auth0 proxy built on top of the Laravel platform.

## Usage

This project was designed to be docker first, but certainly can be deployed on other platforms. It was also designed to be configurable 100% from environment variables.

For a great primer on the available environment configuration, [check out the official Laravel docs](https://laravel.com/docs/9.x/configuration#environment-configuration).

### Minimum Configuration

First let's take a look at the minimum configuration required to proxy to another service.

- `APP_KEY` - A base64 encoded application key. You can use Laravel's very own `artisan` cli to generate it with `php artisan key:generate`
- `PROXY_BASE_URL` - The URL you want to proxy to
- `AUTH0_CLIENT_ID` - The Auth0 Client ID to log your users in with
- `AUTH0_CLIENT_SECRET` - The Auth0 Secret to log your users in with
- `AUTH0_REDIRECT_URI` - The application url you want Auth0 to redirect you back to - this will be your domain name + `/auth/callback`
- `AUTH0_BASE_URL` - The Auth0 domain name you are retrieving a token from (usually https://example-corp.auth0.com)

Using these values, would give you a proxy that:

- will check your cookies to see if you have a session
- if not, will send you to auth0 to grab your user information and give you a session
- if so, will ensure that you actually are known to the application
- then will proxy the content you requested returning the proper status codes, mime-types, etc

This configuration might be useful when this proxy has access to internal (i.e. accessible only to the proxy) materials that you want to authenticate public users to.

### Docker Runtime

Cool, so you know how to configure it, now what? Well, if you have used docker before this should be pretty familiar. This image is hosted publicly on DockerHub and shouldn't require any spice.

To pull and run this image locally, you would do something like:

```
docker run -e APP_KEY=<value> -P chaseconey/auth0-proxy
```

Make sure to pass in all of the required values from the minimum configuration section.

### Password-Protected Endpoints

Another common setup that necessitates a proxy is when you have a password protected site that you want to grab access to, but using a different auth mechanism. We can do that too!

You can simply add the basic auth credentials as additional configuration

- `PROXY_AUTH_USERNAME`
- `PROXY_AUTH_PASSWORD`

### External Database

By default, the proxy will use a local sqlite database to store user information for ease of use. Obviously, for larger installations, you might want to move that off into a separate database. Laravel has an adapter for most major engines out of the box.

For example, if you wanted to use a MySQL database, you would add the follow additional configuration:

- `DB_CONNECTION` -`mysql`
- `DB_HOST` - The FQDN of the MySQL host
- `DB_PORT` (optional, default: `3306`)
- `DB_DATABASE` - The name of the database
- `DB_USERNAME`
- `DB_PASSWORD`

For other configuration options, check out the [Laravel database docs](https://laravel.com/docs/9.x/database#configuration).

### Load-balanced Configuration

In some situations you may want to load-balance the proxy, and there are a few things to keep in mind if you want to move into that configuration.

1. You need to distribute the database
2. You need to distribute the sessions

We covered distributing the database in the above section, so let's focus on the session configuration. By default session's are stored on the local filesystem. There are lots of options to use here, but if you are already using MySQL, you might just use the `database` driver.

As before, this is just some additional configuration.

- `SESSION_DRIVER` - `database`

To see all the session options, check out the [Laravel session docs](https://laravel.com/docs/9.x/session#configuration).

### Other Config Values

- [Logging](https://laravel.com/docs/9.x/logging#configuration)