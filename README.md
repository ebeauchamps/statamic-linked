statamic-linked
=================

A Statamic fieldtype to link two or more fields. For example, when your users choose the 
Country, the State/Provinces drop-down is populated with the appropriate data.

1. Install
2. Add at least two `linked` fields to a page/entry fieldtype
	- the 'top' field (not being linked i.e. the starting one) loads it's data from the `options_file`
	- it also needs a field to link to (`link_to`). When the user chooses a value the linked to
	  field will load the appropriate values from the 'selection'.yaml (i.e. `canada.yaml` if the user chooses Canada)
	- the linked field (`province` in the example below)

## Example

Two fields, Country and Province/State.
	
```
  country:
    type: linked
    display: Country
    allow_blank: true
    options_file: countries
    link_to: province

  province:
    type: linked
    display: Province/State
    options_key: provinces
```

countries.yaml:
```
countries:
  canada: Canada
  us: United States
```

canada.yaml:
```
provinces:
    ab: Alberta
    bc: British Columbia
    sk: Saskatchewan
```

us.yaml:
```
provinces:
    al: Alabama
    wa: Washington
    ny: New York
```

## LICENSE

[MIT License](http://emd.mit-license.org)