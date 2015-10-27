Content type in menu for Bolt
=============================

This [Bolt](https://bolt.cm/) extension provide an easy way to add content type in menus.

Requirements
------------

* bolt 2.*

Usage
-----

### Menu definition

```yaml
main:
  - title: 'This is the first menu item.'
    class: first
    path: homepage
    label: Home
  - label: Foo
    contenttype: foos
    contenttype_params: # optional
      order: title
      id: '!1'
    ...
```

`contenttype_params` use same keys as [Fetching content](https://docs.bolt.cm/content-fetching). Use `where` causes
directly in the array.

TODO
----
- Custom title
- Custom alt
- Custom class
- Custom label?

License
-------

This library is release under [MIT license](LICENSE).
