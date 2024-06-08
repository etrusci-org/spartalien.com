# LazyMedia

Embed stuff on your website with simple JSON code.

File: [src/ts/lazymedia.ts](../../src/ts/lazymedia.ts)

---




## Basic Usage

```html
<body>
    <!-- Add some lazycode -->
    <div class="lazycode">{
        "type": "bandcamptrack",
        "slug": "3269640172"
    }</div>

    <!-- 
    the <div> will be replaced with:
    
    <iframe
        src="https://bandcamp.com/EmbeddedPlayer/track=2939601556..."
        loading="lazy"
        class="lazymedia bandcamptrack"
    ></iframe>
    -->

    <script type="module">
        window.addEventListener('load', () => {
            // Import class
            import { LazyMedia } from './lazymedia.js'

            // Init class
            const LM = new LazyMedia()

            // Optionally adjust some defaults if you need to
            // LM.element_selector = '.lazycode'
            // LM.videobox_class = 'videobox'
            // LM.error_class = 'error'

            // You can also override the slug templates:
            // LM.slug_template.bandcamptrack = 'https://bandcamp.com/EmbeddedPlayer/track={SLUG}/tracklist=false/size=large/bgcol=ffffff/linkcol=000000/artwork=none/transparent=true/',

            // Auto-embed all lazycode elements...
            LM.autoembed()

            // ...or do it programmatically by using the other class methods
        })
    </script>
</body>
```

---




## LazyCode

A **lazycode** is just a [JSON](https://json.org) object. To use it with `autoembed()` you wrap it inside a [HTMLElement](https://developer.mozilla.org/en-US/docs/Web/API/) with the class `lazycode` (see usage example above).

The attributes `type` and `slug` are mandatory for all types.  
The attributes `class` and `attr` are optional for all types.  
Some types have additional optional attributes.


### Types

| Type               | Supported Attributes                      | Returned Element |
|--------------------|-------------------------------------------|------------------|
| `link`             | `attr`, `class`, `text`, `target`         | [HTMLAnchorElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLAnchorElement) |
| `image`            | `attr`, `class`, `alt`, `linkto`          | [HTMLImageElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLImageElement) or [HTMLAnchorElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLAnchorElement) &larr; [HTMLImageElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLImageElement) if `linkto` attribubute is set |
| `audio`            | `attr`, `class`                           | [HTMLAudioElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLAudioElement) |
| `video`            | `attr`, `class`                           | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLVideoElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLVideoElement) &larr; [HTMLAnchorElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLAnchorElement) |
| `bandcamptrack`    | `attr`, `class`                           | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `bandcampalbum`    | `attr`, `class`, `trackcount`             | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `spotifytrack`     | `attr`, `class`, `usetheme`               | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `spotifyalbum`     | `attr`, `class`, `usetheme`, `trackcount` | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `spotifyplaylist`  | `attr`, `class`, `usetheme`, `trackcount` | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `mixcloudshow`     | `attr`, `class`                           | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `mixcloudplaylist` | `attr`, `class`                           | [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `twitchstream`     | `attr`, `class`                           | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `twitchchat`       | `attr`, `class`                           | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `youtubevideo`     | `attr`, `class`, `start`                  | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `youtubeplaylist`  | `attr`, `class`                           | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |
| `odyseevideo`      | `attr`, `class`                           | [HTMLDivElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLDivElement) &larr; [HTMLIFrameElement](https://developer.mozilla.org/en-US/docs/Web/API/HTMLIFrameElement) |


### Slug

A **slug** is whatever is needed to bake the embed.  
For example, for **type** `link` it is an URL or path.

| Type               | Valid Slug Values |
|--------------------|-------------------|
| `link`             | Any URL or Path |
| `image`            | URL or Path to image file |
| `audio`            | URL or Path to audio file |
| `video`            | URL or Path to video file |
| `bandcamptrack`    | Track ID |
| `bandcampalbum`    | Album ID |
| `spotifytrack`     | Track ID |
| `spotifyalbum`     | Album ID |
| `spotifyplaylist`  | Playlist ID |
| `mixcloudshow`     | `<USERNAME>/<PLAYLIST_KEY>` |
| `mixcloudplaylist` | `<USERNAME>/playlists/<PLAYLIST_KEY>` |
| `twitchstream`     | `<CHANNEL_NAME>&parent=<PARENT_DOMAIN>` |
| `twitchchat`       | `<CHANNEL_NAME>/chat?parent=<PARENT_DOMAIN>[&darkpopout]` |
| `youtubevideo`     | Video ID |
| `youtubeplaylist`  | Playlist ID |
| `odyseevideo`      | `<@CHANNEL>/<VIDEO_ID>` |


### Optional Attributes

| Attribute          | Supported Types                                    | Valid Attribute Values |
|--------------------|----------------------------------------------------|------------------------|
| `class`            | *all*                                              | Array of CSS class names to add to the output element |
| `attr`             | *all*                                              | Array of Arrays with key-value attributes to add to the output element |
| `text`             | `link`                                             | Any text |
| `target`           | `link`                                             | [HTMLAnchorElement target value](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a#attributes) |
| `alt`              | `image`                                            | [HTMLImageElement alt value](https://developer.mozilla.org/en-US/en-US/docs/Web/HTML/Element/img#attributes) |
| `linkto`           | `image`                                            | [HTMLAnchorElement target value](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a#attributes) |
| `trackcount`       | `bandcampalbum`, `spotifyalbum`, `spotifyplaylist` | [Positive natural number](https://en.wikipedia.org/wiki/Natural_number) track count of the album or playlist - if set, the embed height will be auto-calculated |
| `usetheme`         | `spotifytrack`, `spotifyalbum`, `spotifyplaylist`  | [Boolean](https://en.wikipedia.org/wiki/Boolean_data_type) that indicates whether to use the auto-theme (based on coverart colors) from Spotify |
| `start`            | `youtubevideo`                                     | Time in [seconds](https://en.wikipedia.org/wiki/Second) at which point the video should start |

---




## LazyCode Examples

See [test.html](./test.html) for more.

Simple link:
```json
{
    "type": "link",
    "slug": "https://example.org"
}
```

Link with custom link text, title and target:
```json
{
    "type": "link",
    "slug": "https://example.org",
    "text": "click me!",
    "target": "_blank",
    "attr": [
        ["title", "hello cruel world"]
    ]
}
```

Video that auto-plays and loops and custom css classes:

```json
{
    "type": "video",
    "slug": "./test.mp4",
    "attr": [
        ["autoplay", "autoplay"],
        ["loop", "loop"]
    ],
    "class": [
        "your-custom-css-class-1", 
        "your-custom-css-class-2"
    ]
}
```

---




## License

See [LICENSE.md](./LICENSE.md)
