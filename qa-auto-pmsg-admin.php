<?php

class qa_auto_pmsg_admin
{
	public function option_default($option)
	{
		switch ($option) {
			case 'qa_auto_pmsg_from_handle':
				return qa_lang_html('qa_apmsg_lang/default_handle');
			case 'qa_auto_pmsg_message_for_posted':
				return qa_lang_html('qa_apmsg_lang/default_for_posted');
			case 'qa_auto_pmsg_message_for_no_posted':
				return qa_lang_html('qa_apmsg_lang/default_for_no_post');
			default:
				return;
		}
	}

	public function allow_template($template)
	{
		return $template != 'admin';
	}

	public function admin_form(&$qa_content)
	{
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('qa_auto_pmsg_save')) {
			qa_opt('qa_auto_pmsg_from_handle', qa_post_text('qa_auto_pmsg_from_handle'));
			qa_opt('qa_auto_pmsg_message_for_posted', qa_post_text('qa_auto_pmsg_message_for_posted'));
			qa_opt('qa_auto_pmsg_message_for_no_posted', qa_post_text('qa_auto_pmsg_message_for_no_posted'));
			$ok = qa_lang('admin/options_saved');
		}

		// form fields to display frontend for admin
		$fields = array();

		$fields[] = array(
			'label' => qa_lang_html('qa_apmsg_lang/from_handle'),
			'tags' => 'NAME="qa_auto_pmsg_from_handle"',
			'value' => qa_opt('qa_auto_pmsg_from_handle'),
			'type' => 'text'
		);
		
		$fields[] = array(
			'label' => qa_lang_html('qa_apmsg_lang/to_posted_user'),
			'tags' => 'name="qa_auto_pmsg_message_for_posted"',
			'value' => qa_opt('qa_auto_pmsg_message_for_posted'),
			'type' => 'textarea',
		);
		
		$fields[] = array(
			'label' => qa_lang_html('qa_apmsg_lang/to_no_posted_user'),
			'tags' => 'name="qa_auto_pmsg_message_for_no_posted"',
			'value' => qa_opt('qa_auto_pmsg_message_for_no_posted'),
			'type' => 'textarea',
		);

		return array(
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="qa_auto_pmsg_save"',
				),
			),
		);
	}
}
