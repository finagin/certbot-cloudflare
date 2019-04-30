<h1>CloudFlare <sub><sup>CertBot</sup></sub></h1>

[![Software License][ico-license]](LICENSE)

## Usage
```bash
./letsencrypt-auto certonly \
            --manual-public-ip-logging-ok \
            --agree-tos \
            --email igor@finag.in \
            --renew-by-default \
            -d example.com \
            -d *.example.com \
            --manual \
            --manual-auth-hook /tmp/certbot/auth.php \
            --manual-cleanup-hook /tmp/certbot/cleanup.php \
            --preferred-challenges dns-01 \
            --server https://acme-v02.api.letsencrypt.org/directory
```

## Development
```bash
git config gitflow.branch.master release && \
git config gitflow.branch.develop master && \
git config gitflow.prefix.release prerelease/ && \
git config gitflow.prefix.feature feature/ && \
git config gitflow.prefix.support support/ && \
git config gitflow.prefix.bugfix bugfix/ && \
git config gitflow.prefix.hotfix hotfix/ && \
git config gitflow.prefix.versiontag && \
git flow init
```

## License

The MIT License ([MIT](https://opensource.org/licenses/MIT)). Please see [License File](LICENSE) for more information.

<!-- Icons -->

[ico-license]: https://img.shields.io/github/license/mashape/apistatus.svg
