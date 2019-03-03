# Cortex Auth Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v2.0.0] - 2019-03-03
- Require PHP 7.2 & Laravel 5.8
- Utilize includeWhen blade directive
- Add files option to the form to allow file upload
- Fix wrong authorization check method for superadmins
- Add missing managerarea.home breadcrumb
- Refactor managed roles/abilities retrieval
- Drop ownership feature of tenants

## [v1.0.3] - 2019-01-03
- Rename environment variable QUEUE_DRIVER to QUEUE_CONNECTION
- Fix wrong media destroy route
- Force save password regardless of any other fields validation errors
  - This action only deal with password change anyway.
- Simplify and flatten create & edit form controller actions
- Tweak and simplify FormRequest validations

## [v1.0.2] - 2018-12-23
- Fix wrong pragmarx/google2fa dependency version

## [v1.0.1] - 2018-12-22
- Update composer dependencies

## [v1.0.0] - 2018-10-01
- Support Laravel v5.7, bump versions and enforce consistency

## v0.0.1 - 2018-09-22
- Tag first release

[v2.0.0]: https://github.com/rinvex/cortex-auth-b2b2c2/compare/v1.0.3...v2.0.0
[v1.0.3]: https://github.com/rinvex/cortex-auth-b2b2c2/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/rinvex/cortex-auth-b2b2c2/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/rinvex/cortex-auth-b2b2c2/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/rinvex/cortex-auth-b2b2c2/compare/v0.0.1...v1.0.0
