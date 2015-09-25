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
    - another linked field if you whish (`city` in the example below) which is going to be linked to the one before (`province`)

## Example

Three fields, Country, Province/State and City.
	
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
    link_to: city

  city:
    type: linked
    display: Main City
    options_key: cities
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

ab.yaml:
```
cities:
  Edmonton: Edmonton
  Calgary: Calgary
  RedDeer: "Red Deer"
``` 

bc.yaml:
```
cities:
  Vancouver: Vancouver
  Surrey: Surrey
  Kelowna: Kelowna
  Richmond: Richmond
```
  
and so on for every cities.

## LICENSE

[MIT License](http://emd.mit-license.org)