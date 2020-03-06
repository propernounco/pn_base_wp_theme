<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

echo '<div id="seopress-page-speed-results" class="metabox-holder">';

    echo '<div id="postbox-container-1" class="postbox-container">';
        if ( get_transient( 'seopress_results_page_speed' ) == true ) {
            //Init
            $seopress_page_speed_results = array();

            $seopress_page_speed_results = json_decode(get_transient( 'seopress_results_page_speed' ), true);
           
            //Color Score
            if (!empty($seopress_page_speed_results)) {
                $ps_score = ($seopress_page_speed_results['lighthouseResult']['audits']['speed-index']['score'])*100;

                if ($ps_score < '70') { //Low score
                    $seopress_page_speed_bar = '#F05050';
                } elseif ($ps_score >= '90') { //High scrore
                    $seopress_page_speed_bar = '#27C24C';
                } else {
                    $seopress_page_speed_bar = '#FAD733'; //Intermediate score
                }

                echo '<div class="wrap-seopress-score postbox">';

                    echo '<h2 class="hndle ui-sortable-handle"><span>'.__('Google Page Speed Score (Desktop)','wp-seopress-pro').'</span></h2>';

                    echo '<div class="inside">
                            <div class="main">';
                            echo '<div class="wrap-chart">';
                                echo '<div class="chart" data-percent="'.$ps_score.'" data-scale-color="#CCC"><span>'.$ps_score.'%</span></div>';

                                echo "<script>
                                        jQuery(function() {
                                            jQuery('.chart').easyPieChart({
                                                barColor: '".$seopress_page_speed_bar."',
                                                lineCap: 'square',
                                                lineWidth: '12',
                                                size: '200',
                                            });
                                        });
                                    </script>";
                            echo '</div>';
                            echo '<div class="wrap-info">';
                                echo '<div class="your-id"><span>'.__('URL: ','wp-seopress-pro').'</span>'.$seopress_page_speed_results['id'].'</div>';
                                echo '<div class="your-title"><span>'.__('Title: ','wp-seopress-pro').'</span>'.$seopress_page_speed_results['lighthouseResult']['finalUrl'].'</div>';
                                
                                echo '<p>'.__('The speed score is based on the lab data analyzed by Lighthouse.','wp-seopress-pro').'</p>';
                                
                                $fetchTime = $seopress_page_speed_results['lighthouseResult']['fetchTime'];
                                
                                echo '<div class="last-date-analysis"><span>'.__('Analysis time: ','wp-seopress-pro').'</span>'.date_i18n( get_option( 'date_format' ), strtotime($fetchTime)).__(' at ','wp-seopress-pro').date('H:i',strtotime($fetchTime)).'</div>';
                            echo '</div>';
                            echo '<div class="wrap-scale">';
                                echo __('<strong>Scale:</strong> <span class="fast"></span>90-100 (fast) <span class="average"></span>50-89 (average) <span class="slow"></span>0-49 (slow)','wp-seopress-pro');
                            echo '</div>';
                            echo '<div class="clearfix"></div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            
            //Screenshots
            echo '<div id="postbox-container-2" class="postbox-container">';
                echo '<div class="wrap-seopress-score postbox">';

                    echo '<h2 class="hndle ui-sortable-handle"><span>'.__('Screenshot','wp-seopress-pro').'</span></h2>';
                    echo '<div class="inside">
                            <div class="main">';
                                echo '<div class="your-screenshot"><img src="'.$seopress_page_speed_results['lighthouseResult']['audits']['final-screenshot']['details']['data'].'"/></div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
            echo '</div>';
            
            //Audits
            echo '<div id="postbox-container-3" class="postbox-container">';
                echo '<div class="wrap-seopress-score postbox">';
                
                //FIELD DATA
                if (isset($seopress_page_speed_results['loadingExperience']['overall_category'])) {
                    $ps_speed = $seopress_page_speed_results['loadingExperience']['overall_category'];
                } else {
                    $ps_speed = NULL;
                }
                echo '<div class="wrap-speed-'.$ps_speed.'">';
                    echo '<h2><span class="dashicons dashicons-chart-bar"></span>'.__('Field Data','wp-seopress-pro').'</h2>';
                    echo '<p class="ps-desc">'.sprintf(__('Over the last 30 days, the field data shows that this page has a <span>%s</span> speed compared to other pages in the Chrome User Experience Report. We are showing the 90th percentile of FCP and the 95th percentile of FID.','wp-seopress-pro'), $ps_speed).'</p>';

                    if (isset($seopress_page_speed_results['loadingExperience']['metrics'])) {
                        $FIRST_CONTENTFUL_PAINT_MS_PERCENTILE = $seopress_page_speed_results['loadingExperience']['metrics']['FIRST_CONTENTFUL_PAINT_MS']['percentile'];
                    } else {
                        $FIRST_CONTENTFUL_PAINT_MS_PERCENTILE = NULL;
                    }

                    echo '<p class="metric-desc">'.__('First Contentful Paint (FCP): ','wp-seopress-pro').'<span class="metric-value">'.round($FIRST_CONTENTFUL_PAINT_MS_PERCENTILE/1000,2).__(' s','wp-seopress-pro').'</span></p>';

                    if (isset($seopress_page_speed_results['loadingExperience']['metrics']['FIRST_CONTENTFUL_PAINT_MS']['distributions'])) {
                        $FIRST_CONTENTFUL_PAINT_MS = $seopress_page_speed_results['loadingExperience']['metrics']['FIRST_CONTENTFUL_PAINT_MS']['distributions'];
                    } else {
                        $FIRST_CONTENTFUL_PAINT_MS = NULL;
                    }

                    if ($FIRST_CONTENTFUL_PAINT_MS !='') {
                        echo '<div class="wrap-dist">';
                            foreach($FIRST_CONTENTFUL_PAINT_MS as $value) {
                                $proportion = round($value['proportion'] * 100,2);
                                echo '<div class="ps-fast" style="flex-grow:'.$proportion.'">'.$proportion.'%</div>';
                            }
                        echo '</div>';
                    }

                    if (isset($seopress_page_speed_results['loadingExperience']['metrics'])) {
                        $FIRST_INPUT_DELAY_MS_PERCENTILE = $seopress_page_speed_results['loadingExperience']['metrics']['FIRST_INPUT_DELAY_MS']['percentile'];
                    } else {
                        $FIRST_INPUT_DELAY_MS_PERCENTILE = NULL;
                    }
                    
                    echo ' | <p class="metric-desc">'.__('First Input Delay (FID): ','wp-seopress-pro').'<span class="metric-value">'.$FIRST_INPUT_DELAY_MS_PERCENTILE.__(' ms','wp-seopress-pro').'</span></p>';
                    
                    if (isset($seopress_page_speed_results['loadingExperience']['metrics'])) {
                        $FIRST_INPUT_DELAY_MS = $seopress_page_speed_results['loadingExperience']['metrics']['FIRST_INPUT_DELAY_MS']['distributions'];
                    } else {
                        $FIRST_INPUT_DELAY_MS = NULL;
                    }
                    
                    if ($FIRST_INPUT_DELAY_MS !='') {
                        echo '<div class="wrap-dist">';
                            foreach($FIRST_INPUT_DELAY_MS as $value) {
                                $proportion = round($value['proportion'] * 100,2);
                                echo '<div class="ps-fast" style="flex-grow:'.$proportion.'">'.$proportion.'%</div>';
                            }
                        echo '</div>';
                    }
                echo '</div>';
                
                //LAB DATA
                echo '<div class="lab-data">';
                    echo '<h2><span class="dashicons dashicons-dashboard"></span>'.__('Lab Data','wp-seopress-pro').'</h2>';
                    echo '<p class="ps-desc">'.__('Lighthouse analysis of the current page on an emulated mobile network. Values are estimated and may vary.','wp-seopress-pro').'</p>';
                    
                    echo '<ul>';
                        //First Contentful Paint
                        echo '<li>';
                            $firstContentfulPaint = ($seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstContentfulPaint'] / 1000);
                            echo '<span class="data-desc">'.__('First Contentful Paint: ','wp-seopress-pro').'</span><span class="data-value">'.$firstContentfulPaint.__(' s','wp-seopress-pro').'</span>';
                        echo '</li>';
                        
                        //First Meaningful Paint
                        echo '<li>';
                            $firstMeaningfulPaint = ($seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstMeaningfulPaint']) / 1000;
                            echo '<span class="data-desc">'.__('First Meaningful Paint: ','wp-seopress-pro').'</span><span class="data-value">'.$firstMeaningfulPaint.__(' s','wp-seopress-pro').'</span>';
                        echo '</li>';
                        
                        //Speed Index
                        echo '<li>';
                            $speedIndex = ($seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['speedIndex'] / 1000);
                            echo '<span class="data-desc">'.__('Speed Index: ','wp-seopress-pro').'</span><span class="data-value">'.$speedIndex.__(' s','wp-seopress-pro').'</span>';
                        echo '</li>';
                        
                        //First CPU Idle
                        echo '<li>';
                            $firstCPUIdle = ($seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['firstCPUIdle'] / 1000);
                            echo '<span class="data-desc">'.__('First CPU Idle: ','wp-seopress-pro').'</span><span class="data-value">'.$firstCPUIdle.__(' s','wp-seopress-pro').'</span>';
                        echo '</li>';
                        
                        //Time to Interactive
                        echo '<li>';
                            $interactive = ($seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['interactive'] / 1000);
                            echo '<span class="data-desc">'.__('Time to Interactive: ','wp-seopress-pro').'</span><span class="data-value">'.$interactive.__(' s','wp-seopress-pro').'</span>';
                        echo '</li>';
                        
                        //Estimated Input Latency
                        echo '<li>';
                            echo '<span class="data-desc">'.__('Estimated Input Latency: ','wp-seopress-pro').'</span><span class="data-value">'.date('s',$seopress_page_speed_results['lighthouseResult']['audits']['metrics']['details']['items'][0]['estimatedInputLatency']).__(' ms','wp-seopress-pro').'</span>';
                        echo '</li>';
                    echo '</ul>';

                    $screenshot_thumbnails = $seopress_page_speed_results['lighthouseResult']['audits']['screenshot-thumbnails']['details']['items'];
                    
                    if (!empty($screenshot_thumbnails)) {
                        echo '<ul class="screens">';
                        foreach($screenshot_thumbnails as $value) {
                            echo '<li>';
                                echo '<img src="'.$value['data'].'"/>';
                                echo '<span>'.round($value['timing']/1000,2).__(' s','wp-seopress-pro').'</span>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                echo '</div>';
                
                //Opportunities
                echo '<h2><span class="dashicons dashicons-welcome-add-page"></span>'.__('Opportunities','wp-seopress-pro').'</h2>';
                echo '<p class="ps-desc">'.__('These optimizations can speed up your page load.','wp-seopress-pro').'</p>';
                
                if (!empty($seopress_page_speed_results['lighthouseResult']['audits'])) {
                    foreach ($seopress_page_speed_results['lighthouseResult']['audits'] as $key => $audit) {
                        echo '<div class="wrap-detail-opp">';
                            if ($audit['score'] !='1' && isset($audit['details']['type']) && $audit['details']['type']=='opportunity') {
                                
                                if (!empty($audit['title'])) {
                                    echo '<h3 class="ps-audit-title">'.$audit['title'].'</h3>';
                                }
                                if (!empty($audit['description'])) {
                                    echo '<p class="ps-audit-desc">'.$audit['description'].'</p>';
                                }
                                preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', trim($audit['description'], ').'), $matches);
                                if ($matches[0]) {
                                    echo '<p class="learn-more"><a target="_blank" rel="noopener noreferrer nofollow" href="'.$matches[0].'">'.__('Learn more','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span></p>';
                                }
                                if (!empty($audit['details']['items'])) {
                                    echo '<ul>';
                                    foreach ($audit['details']['items'] as $item) {
                                        echo '<li>';
                                        if (!empty($item['url'])) {
                                            echo '<span class="w-60">'.$item['url'].'</span>';
                                        }
                                        if (!empty($item['totalBytes'])) {
                                            echo '<span class="w-20">'.round($item['totalBytes']/1000, 0).__(' KB','wp-seopress-pro').'</span>';
                                        }
                                        if (!empty($item['wastedMs'])) {
                                            echo '<span class="w-20">'.$item['wastedMs'].__(' ms','wp-seopress-pro').'</span>';
                                        }
                                        if (!empty($item['wastedBytes'])) {
                                            echo '<span class="w-20">'.round($item['wastedBytes']/1000,0).__(' KB','wp-seopress-pro').'</span>';
                                        }
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                            }
                        echo '</div>';
                    }
                }

                //Diagnostics
                echo '<h2><span class="dashicons dashicons-welcome-add-page"></span>'.__('Diagnostics','wp-seopress-pro').'</h2>';
                echo '<p class="ps-desc">'.__('More information about the performance of your application.','wp-seopress-pro').'</p>';
                
                if (!empty($seopress_page_speed_results['lighthouseResult']['audits'])) {
                    foreach ($seopress_page_speed_results['lighthouseResult']['audits'] as $key => $audit) {
                        echo '<div class="wrap-detail-opp">';
                            if ($audit['score'] =='' && isset($audit['details']['type']) && $audit['details']['type']=='table') {
                                
                                if (!empty($audit['title'])) {
                                    echo '<h3 class="ps-audit-title">'.$audit['title'].'</h3>';
                                }
                                if (!empty($audit['description'])) {
                                    echo '<p class="ps-audit-desc">'.$audit['description'].'</p>';
                                }
                                preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', trim($audit['description'], ').'), $matches);
                                if (isset($matches[0]) && $matches[0]) {
                                    echo '<p class="learn-more"><a target="_blank" rel="noopener noreferrer nofollow" href="'.$matches[0].'">'.__('Learn more','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span></p>';
                                }
                                if (!empty($audit['details']['items'])) {
                                    echo '<ul>';
                                    echo '<li class="w-60">'.__('URL','wp-seopress-pro').'</li>';
                                    echo '<li class="w-20">'.__('Size/Time','wp-seopress-pro').'</li>';
                                    echo '<li class="w-20">'.__('Estimated Savings','wp-seopress-pro').'</li>';
                                    echo '</ul>';
                                    echo '<ul>';
                                    foreach ($audit['details']['items'] as $item) {
                                        echo '<li>';
                                        if (!empty($item['url'])) {
                                            echo '<span class="w-60">'.$item['url'].'</span>';
                                        }
                                        if (!empty($item['totalBytes'])) {
                                            echo '<span class="w-20">'.round($item['totalBytes']/1000, 0).__(' KB','wp-seopress-pro').'</span>';
                                        }
                                        if (!empty($item['wastedMs'])) {
                                            echo '<span class="w-20">'.round($item['wastedMs'], 0).__(' ms','wp-seopress-pro').'</span>';
                                        }
                                        if (!empty($item['wastedBytes'])) {
                                            echo '<span class="w-20">'.round($item['wastedBytes']/1000,0).__(' KB','wp-seopress-pro').'</span>';
                                        }
                                        echo '</li>';
                                    }
                                    echo '</ul>';
                                }
                            }
                        echo '</div>';
                    }
                }

                //Passed audits
                echo '<h2><span class="dashicons dashicons-welcome-add-page"></span>'.__('Passed audits','wp-seopress-pro').'</h2>';
                
                if (!empty($seopress_page_speed_results['lighthouseResult']['audits'])) {
                    foreach ($seopress_page_speed_results['lighthouseResult']['audits'] as $key => $audit) {
                        //if (array_key_exists($audit['details']['type'], $audit) && array_key_exists($audit['score'], $audit)) {
                            echo '<div class="wrap-detail-opp">';
                                if ($audit['score'] =='1') {
                                    
                                    if (!empty($audit['title'])) {
                                        echo '<h3 class="ps-audit-title">'.$audit['title'].'</h3>';
                                    }
                                    if (!empty($audit['description'])) {
                                        echo '<p class="ps-audit-desc">'.$audit['description'].'</p>';
                                    }
                                    preg_match('/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', trim($audit['description'], ').'), $matches);
                                    if (!empty($matches[0])) {
                                        echo '<p class="learn-more"><a target="_blank" rel="noopener noreferrer nofollow" href="'.$matches[0].'">'.__('Learn more','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span></p>';
                                    }
                                    if (!empty($audit['details']['items'])) {
                                        echo '<ul>';
                                        foreach ($audit['details']['items'] as $item) {
                                            echo '<li>';
                                            if (!empty($item['url'])) {
                                                echo '<span class="w-60">'.$item['url'].'</span>';
                                            }
                                            if (!empty($item['totalBytes'])) {
                                                echo '<span class="w-20">'.round($item['totalBytes']/1000, 0).__(' KB','wp-seopress-pro').'</span>';
                                            }
                                            if (!empty($item['wastedMs'])) {
                                                echo '<span class="w-20">'.$item['wastedMs'].__(' ms','wp-seopress-pro').'</span>';
                                            }
                                            if (!empty($item['wastedBytes'])) {
                                                echo '<span class="w-20">'.round($item['wastedBytes']/1000,0).__(' KB','wp-seopress-pro').'</span>';
                                            }
                                            echo '</li>';
                                        }
                                        echo '</ul>';
                                    }
                                }
                            echo '</div>';
                        //}
                    }
                }
            }
        echo '</div>';
    } else {
        echo '<p>'.__('We can\'t retrieve your Google Page Speed. Make sure your site is accessible from everyone, and try again.','wp-seopress-pro').'</p>';
    }
    echo '</div>';
echo '</div>';

echo "<div style='clear:both'></div>";