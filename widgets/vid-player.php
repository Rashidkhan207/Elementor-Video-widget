<?php
use Elementor\Modules\DynamicTags\Module as TagsModule;
class POLARIS_Video_Player extends \Elementor\Widget_Base {

    public function get_name() {
        return "polaris_video_player";
    }

    public function get_title() {
        return esc_html__( "Polaris Video Player", 'polaris' );
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_categories() {
        return array( 'general' );
    }
    
    public function get_script_depends() {
        return [
            'plyr',
            'plyr-polyfilled',
            'polaris-main',
        ];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Allgemeine Videooptionen', 'polaris' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label' => esc_html__( 'Videotyp', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube'  => esc_html__( 'Youtube video', 'polaris' ),
                    'vimeo' => esc_html__( 'Vimeo video', 'polaris' ),
                    'html5' => esc_html__( 'Standard Video', 'polaris' ),
                ],

            ]
        );

        $this->add_control(
            'poster',
            [
                'label' => esc_html__( 'Plakat für Video', 'polaris' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'separator' => 'before',
                'condition' => [
                    'video_type'    =>  'html5',
                ],
            ]
        );

        $this->add_control(
            'youtube_video_id',
            [
                'label' => esc_html__( 'Youtube Video ID', 'polaris' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'hNQFjqDvPhA', 'polaris' ),
                'placeholder' => esc_html__( 'Put your video id here', 'polaris' ),
                'separator' => 'before',
                'condition' => [
                    'video_type'    =>  'youtube',
                ]
            ]
        );
		
        $this->add_control(
            'vimeo_video_id',
            [
                'label' => esc_html__( 'Vimeo Video ID', 'polaris' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( '299795188', 'polaris' ),
                'placeholder' => esc_html__( 'Put your video id here', 'polaris' ),
                'separator' => 'before',
                'condition' => [
                    'video_type'    =>  'vimeo',
                ]
            ]
        );
		
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'src_type',
            [
                'label' => esc_html__( 'Video Source', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'link',
                'options' => [
                    'upload' => esc_html__( 'Upload Video', 'polaris' ),
                    'link' => esc_html__( 'Put Video Link', 'polaris' ),
                ],
            ]
        );
        $repeater->add_control(
            'video_upload',
            [
                'label' => esc_html__( 'Video hochladen', 'polaris' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                    'categories' => [
                        TagsModule::MEDIA_CATEGORY,
                    ],
                ],
                'media_type' => 'video',
                'condition' => [
                    'src_type'    =>  'upload',
                ]
            ]
        );

        $repeater->add_control(
            'video_link',
            [
                'label' => esc_html__( 'Video Link', 'polaris' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'polaris' ),
                'show_external' => false,
                'default' => [
                    'url' => 'https://devweb89.000webhostapp.com/film1.mp4',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'src_type'    =>  'link',
                ]
            ]
        );

        $repeater->add_control(
            'video_size',
            [
                'label' => esc_html__( 'Video Size', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__( 'Select', 'polaris' ),
                    '240' => esc_html__( '240', 'polaris' ),
                    '360' => esc_html__( '360', 'polaris' ),
                    '480' => esc_html__( '480', 'polaris' ),
                    '576' => esc_html__( '576', 'polaris' ),
                    '720' => esc_html__( '720', 'polaris' ),
                    '1080' => esc_html__( '1080', 'polaris' ),
                    '1440' => esc_html__( '1440', 'polaris' ),
                    '2160' => esc_html__( '2160', 'polaris' ),
                    '2880' => esc_html__( '2880', 'polaris' ),
                    '4320'  => esc_html__( '4320', 'polaris' ),
                ],
            ]
        );

        $this->add_control(
            'video_list',
            [
                'label' => esc_html__( 'Video List', 'polaris' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'video_link' => 'https://devweb89.000webhostapp.com/film1.mp4',
                        'video_size' => esc_html__( '576', 'polaris' ),
                    ],
                    [
                        'video_link' => 'ttps://devweb89.000webhostapp.com/film1.mp4',
                        'video_size' => esc_html__( '720', 'polaris' ),
                    ],
                    [
                        'video_link' => 'ttps://devweb89.000webhostapp.com/film1.mp4',
                        'video_size' => esc_html__( '1080', 'polaris' ),
                    ],
                ],
                'separator' => 'before',
                'condition' => [
                    'video_type'    =>  'html5',
                ]
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Autoplay', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Autoplay the media on load.', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => '',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__( 'Loop', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Loop the current media. ', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => '',
                'separator' => 'before',
            ]
        );
      
        $this->add_control(
            'click_to_play',
            [
                'label' => esc_html__( 'Click To Play', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description'   => esc_html__('Durch Klicken (oder Tippen) auf den Videocontainer wird die Wiedergabe / Pause umgeschaltet.','polaris'),
                'label_on' => esc_html__( 'Enable', 'polaris' ),
                'label_off' => esc_html__( 'Disable', 'polaris' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'invert_time',
            [
                'label' => esc_html__( 'Zeit als Countdown anzeigen', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Zeigen Sie die aktuelle Zeit als Countdown und nicht als inkrementellen Zähler an.', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'seek_time',
            [
                'label' => esc_html__( 'Seek Time', 'polaris' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'description' => esc_html__('Die Zeit in Sekunden, um zu suchen, wann ein Benutzer schnell vor- oder zurückspult.', 'polaris'),
                'min' => 5,
                'max' => 100,
                'step' => 1,
                'default' => 10,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hide_controls',
            [
                'label' => esc_html__( 'Kontrollsymbole nach 2 Sekunden ausblenden', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Blenden Sie die Videosteuerung automatisch aus, nachdem Sie 2 Sekunden lang keine Maus- oder Fokusbewegung ausgeführt haben,', 'polaris'),
                'label_on' => esc_html__( 'Show', 'polaris' ),
                'label_off' => esc_html__( 'Hide', 'polaris' ),
                'return_value' => 'true',
                'default' => 'false',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'reset_on_end',
            [
                'label' => esc_html__( 'Zurück zum Start nach dem Ende', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Zurück zum Start nach dem Ende des Spiels', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'false',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'keyboard_focused',
            [
                'label' => esc_html__( 'Aktivieren Sie Tastaturkürzel im Fokus', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Aktivieren Sie Tastaturkürzel nur für fokussierte Spieler', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'keyboard_global',
            [
                'label' => esc_html__( 'Tastaturkürzel global aktivieren', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'false',
                'separator' => 'before',
            ]
        );

		
        $this->end_controls_section();
		
		
		 // custom player settings
        $this->start_controls_section(
            'controls_section',
            [
                'label' => esc_html__( 'Player Customization', 'polaris' ),
                'tab' => \Elementor\controls_Manager::TAB_CONTENT,
            ]
        );
		
		  $this->add_control(
            'volume',
            [
                'label' => esc_html__( 'Anfangsvolumen', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' =>1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'separator' => 'before',
            ]
        );

		  $this->add_control(
            'tooltips_controls',
            [
                'label' => esc_html__( 'Display Control Labels', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Zeigen Sie Steuerbeschriftungen als QuickInfos an :hover & :focus', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'false',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tooltips_seek',
            [
                'label' => esc_html__( 'Display Seek Tooltip', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Zeigen Sie einen Such-Tooltip an, um beim Klicken anzugeben, wohin das Medium suchen würde.', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'fullscreen_enabled',
            [
                'label' => esc_html__( 'Enable Fullscreen Toggle', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'description' => esc_html__('Aktivieren Sie den Vollbildmodus, wenn Sie auf den Player doppelklicken', 'polaris'),
                'label_on' => esc_html__( 'Yes', 'polaris' ),
                'label_off' => esc_html__( 'No', 'polaris' ),
                'return_value' => 'true',
                'default' => 'true',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'speed_selected',
            [
                'label' => esc_html__( 'Anfangsgeschwindigkeit (Initial Speed)', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'speed_1',
                'options' => [
                    'speed_.5'  => esc_html__( '0.5', 'polaris' ),
                    'speed_.75' => esc_html__( '0.75', 'polaris' ),
                    'speed_1' => esc_html__( '1', 'polaris' ),
                    'speed_1.25' => esc_html__( '1.25', 'polaris' ),
                    'speed_1.5' => esc_html__( '1.5', 'polaris' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'quality_default',
            [
                'label' => esc_html__( 'Anfangsqualität (Initial Quality)', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '576',
                'options' => [
                    '240' => esc_html__( '240', 'polaris' ),
                    '360' => esc_html__( '360', 'polaris' ),
                    '480' => esc_html__( '480', 'polaris' ),
                    '576' => esc_html__( '576', 'polaris' ),
                    '720' => esc_html__( '720', 'polaris' ),
                    '1080' => esc_html__( '1080', 'polaris' ),
                    '1440' => esc_html__( '1440', 'polaris' ),
                    '2160' => esc_html__( '2160', 'polaris' ),
                    '2880' => esc_html__( '2880', 'polaris' ),
                    '4320'  => esc_html__( '4320', 'polaris' ),
                ],
                'separator' => 'before',
                'condition' => [
                    'video_type' => 'html5'
                ]
            ]
        );
		
  $this->add_control(
            'controls',
            [
                'label' => esc_html__( 'Player Control Options', 'polaris' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'description'   =>  esc_html__('Add/Remove your prefered video control options'),
                'multiple' => true,
                'options' => [
                    'play-large'  => esc_html__( 'Play Large', 'polaris' ),
                    'play' => esc_html__( 'Play', 'polaris' ),
                    'progress' => esc_html__( 'Progress Bar', 'polaris' ),
                    'current-time' => esc_html__( 'Current Time', 'polaris' ),
                    'mute' => esc_html__( 'Mute', 'polaris' ),
                    'volume' => esc_html__( 'Volume', 'polaris' ),
                    'captions' => esc_html__( 'Caption', 'polaris' ),
                    'settings' => esc_html__( 'Settings Icon', 'polaris' ),
                    'pip' => esc_html__( 'PIP', 'polaris' ),
                    'airplay' => esc_html__( 'Airplay', 'polaris' ),
                    'fullscreen' => esc_html__( 'Fullscreen', 'polaris' ),
					//'lightbox' => esc_html__( 'Lightbox', 'polaris' ),
                ],
                'default' => [ 'play-large', 'play', 'progress bar', 'current-time', 'mute', 'volume', 'captions', 'settings', 'pip', 'airplay', 'fullscreen' ],
                'separator' => 'before',
            ]
        );
$this->end_controls_section();

        // custom color settings
        $this->start_controls_section(
            'styling_section',
            [
                'label' => esc_html__( 'Color Customization', 'polaris' ),
                'tab' => \Elementor\controls_Manager::TAB_CONTENT,
            ]
        );
		
           $this->add_control(
			'controls_color',
			[
				'label' => __( 'Color (This Module is Underconstruction)', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{controls}} .plyr__controls' => 'color: {{VALUE}}',
				],
				 'separator' => 'before',
			]
		);
		
	$this->end_controls_section();

 }

    protected function render() {
        $settings    = $this->get_settings_for_display();
        $video_type = $settings['video_type'];
        $poster = $settings['poster'];
        $poster = $poster['url'];
        $youtube_video_id = $settings['youtube_video_id'];
        $vimeo_video_id = $settings['vimeo_video_id'];
        $autoplay = $settings['autoplay'] == 'true' ? 'true' : 'false';
        $loop = $settings['loop'] == 'true' ? 'true' : 'false';
        $video_list = $settings['video_list'];
        $volume = $settings['volume'];
        $volume = $settings['volume']['size'];
        $volume = (int) $volume / 100;
        $click_to_play = $settings['click_to_play'] == 'true' ? 'true' : 'false';
        $seek_time = $settings['seek_time'];
        $hide_controls = $settings['hide_controls'] == 'true' ? 'true' : 'false';
        $reset_on_end = $settings['reset_on_end'] == 'true' ? 'true' : 'false';
        $keyboard_focused = $settings['keyboard_focused'] == 'true' ? 'true' : 'false';
        $keyboard_global = $settings['keyboard_global'] == 'true' ? 'true' : 'false';
        $tooltips_controls = $settings['tooltips_controls'] == 'true' ? 'true' : 'false';
        $tooltips_seek = $settings['tooltips_seek'] == 'true' ? 'true' : 'false';
        $invert_time = $settings['invert_time'] == 'true' ? 'true' : 'false';
        $fullscreen_enabled = $settings['fullscreen_enabled'] == 'true' ? 'true' : 'false';
        $speed_selected = $settings['speed_selected'];
        $speed_selected = substr($speed_selected, 6 );
        $quality_default = $settings['quality_default'];
        $controls = $settings['controls'];
		


        // player data settings
        $data_settings = array();
        $data_settings['seek_time'] = $seek_time;
        $data_settings['volume'] = $volume;
        $data_settings['clickToPlay'] = $click_to_play;
        $data_settings['keyboard_focused'] = $keyboard_focused;
        $data_settings['keyboard_global'] = $keyboard_global;
        $data_settings['tooltips_controls'] = $tooltips_controls;
        $data_settings['hideControls'] = $hide_controls;
        $data_settings['resetOnEnd'] = $reset_on_end;
        $data_settings['tooltips_seek'] = $tooltips_seek;
        $data_settings['invertTime'] = $invert_time;
        $data_settings['fullscreen_enabled'] = $fullscreen_enabled;
        $data_settings['speed_selected'] = $speed_selected;
        $data_settings['quality_default'] = $quality_default;
        $data_settings['controls'] = $controls;
		
		
		$settings = $this->get_settings_for_display();
		//$settings['controls_color'] = $settings;
		//echo '<div class="plyr__controls" style="color: ' . $settings['controls_color'] . '"> title</div>';
		
          if($video_type == 'html5'):
        ?>
		
        <video 
            poster="<?php echo esc_attr($poster); ?>"
            class="polaris_player polaris_video"
            <?php echo esc_attr($autoplay == 'true' ? 'autoplay' : ''); ?>
            <?php echo esc_attr($loop == 'true' ? 'loop' : ''); ?>
            data-settings='<?php echo wp_json_encode($data_settings); ?>'
			
        >

            <?php
            $video_link = '';
            foreach($video_list as $item):
                if($item['src_type'] == 'upload'){
                    $video_link = $item['video_upload'];
                    $video_link = $video_link['url'];
                } else {
                    $video_link = $item['video_link'];
                    $video_link = $video_link['url'];
                }

               $extension = $ext = pathinfo($video_link, PATHINFO_EXTENSION);
               $size = $item['video_size'];
            ?>
           
            <source
                src="<?php echo esc_url($video_link); ?>"
                type="video/<?php echo esc_attr($extension); ?>"
                size="<?php echo esc_attr($size); ?>"
            />
            <?php endforeach; ?>
            <a href="<?php echo esc_url($video_link); ?>"
                ><?php echo esc_html__('Download', 'polaris'); ?></a
            >
        </video>
        <?php
        elseif($video_type == 'youtube'):
            ?>
            
            <div class="plyr__video-embed polaris_player polaris_video"
                data-settings='<?php echo wp_json_encode($data_settings); ?>'
				 
            >
                <iframe
                    src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_video_id); ?>?autoplay=<?php echo esc_attr($autoplay); ?>&amp;loop=<?php echo esc_attr($loop) ?>&amp;origin=<?php echo esc_url(get_home_url()); ?>/&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                    allowfullscreen
                    allowtransparency
                    allow="autoplay"
                    ></iframe>
            </div>

        <?php
        elseif($video_type == 'vimeo'):
            ?>
            
            <div class="plyr__video-embed polaris_player polaris_video"
                data-settings='<?php echo wp_json_encode($data_settings); ?>'
            >
                <iframe
                    src="https://player.vimeo.com/video/<?php echo esc_attr($vimeo_video_id) ?>?autoplay=<?php echo esc_attr($autoplay); ?>&amp;loop=<?php echo esc_attr($loop) ?>&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                    allowfullscreen
                    allowtransparency
                    allow="autoplay"
					 
                    ></iframe>
            </div>

        <?php
        endif;
    }
}