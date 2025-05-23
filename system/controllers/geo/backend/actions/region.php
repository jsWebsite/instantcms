<?php

class actionGeoRegion extends cmsAction {

    public function run($country_id = null, $region_id = null) {

        if (!$country_id) {
            return cmsCore::error404();
        }

        $country = $this->model->getItemById('geo_countries', $country_id);
        if (!$country) {
            return cmsCore::error404();
        }

        $region = [
            'country_id' => $country['id']
        ];

        if ($region_id) {
            $region = $this->model->getItemById('geo_regions', $region_id);
        }

        $form = $this->getForm('region');

        if ($this->request->has('submit')) {

            $region = $form->parse($this->request, true);
            $errors = $form->validate($this, $region);

            if (!$errors) {

                if ($region_id) {

                    $this->model->update('geo_regions', $region_id, $region);

                    cmsUser::addSessionMessage(LANG_GEO_REGION_UPDATED, 'success');

                } else {

                    $this->model->insert('geo_regions', $region);

                    cmsUser::addSessionMessage(LANG_GEO_REGION_ADDED, 'success');
                }

                $this->cms_cache->clean('geo.cities');
                $this->cms_cache->clean('geo.regions');

                return $this->redirectToAction('regions', $country_id);
            }

            cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
        }

        $this->cms_template->setPageH1([$country['name'], ($region['name'] ?? LANG_GEO_ADD_REGION)]);

        return $this->cms_template->render('backend/region', [
            'do'      => $region_id ? 'edit' : 'add',
            'region'  => $region,
            'country' => $country,
            'form'    => $form,
            'errors'  => $errors ?? false
        ]);
    }

}
