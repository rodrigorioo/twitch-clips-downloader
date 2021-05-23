# Twitch Clips Downloader

Twitch Clips Downloader es una librería en PHP que permite descargar y guardar un clip de twitch con sólo ingresar su ID.

Esta librería no utiliza la API de Twitch, pero igualmente se requiere el Client ID para hacer el request.

## Instalación

La librería se instala vía composer

```sh
composer install rodrigorioo/twitch-clips-downloader
```

## Uso

Para empezar a utilizarla tenemos que iniciarla con el Client ID (ver sección "Obtener Client ID")

```sh
use TwitchClipDownloader\Twitch;

$twitter = new Twitch('<your_client_id>');
```

Con esto ya podemos llamar a los métodos

## Obtener Client ID de Twitch

Para obtenerlo tenemos que crear una aplicación en Twitch (https://dev.twitch.tv/console) y nos saldrá el Client ID

## Métodos

| Nombre | Retorna |
| ------ | ------ |
| download(clip_id) | Twitch |
| save(directorio?) | void |

## Clases

#### Twitch

- String id - ID del clip
- String url - URL del clip

## Excepciones

| Nombre | Descripción |
| ------ | ------ |
| TwitchClipDownloader\Exceptions\Curl\Curl |  |
| TwitchClipDownloader\Exceptions\Curl\ParseResponse | Hereda de TwitchClipDownloader\Exceptions\Curl\Curl |
| TwitchClipDownloader\Exceptions\Curl\Response | Hereda de TwitchClipDownloader\Exceptions\Curl\Curl | |
| TwitchClipDownloader\Exceptions\Clip\Clip |  |
| TwitchClipDownloader\Exceptions\Clip\Save | Hereda de TwitchClipDownloader\Exceptions\Clip\Clip |

## Tests

En la carpeta tests hay algunos tests básicos para que vean como se utiliza la librería al mismo tiempo que tienen incluídas las capturas de las excepciones.

Para poder utilizarlas, tienen que crear un archivo init.php con el mismo formato que tiene el init_example.php en donde van a setear el Client ID

## License

MIT