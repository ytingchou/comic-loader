# comic-loader
簡易漫畫下載器 (Inspired by https://github.com/profyu/comic-loader)

## Usage
```
Usage: comic_loader.php [options]
Options:
  c, --comic <comic_id>               The comic id from cartoonmad.com
  H, --hash <url_hash>                The comic url hash from catoonmad.com
  e, --episod <episod_number>         The comic episod number
  o, --output-dir <directory_path>    Output directory path
  h, --help                           Print command line manual
```

## Example
海賊王第001卷
* `comic_id`: 1152
* `hash`: c8n3o733a62
* `episod`: 1 (即001卷)
* `output_dir`: output_001

```sh
php comic_loader.php  -c 1152 -H c8n3o733a62 -e 1 -o output_001
```
