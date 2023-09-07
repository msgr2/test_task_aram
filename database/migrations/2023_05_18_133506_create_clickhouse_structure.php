<?php

use Illuminate\Database\Migrations\Migration;

return new class extends \PhpClickHouseLaravel\Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        static::write(
            "CREATE TABLE IF NOT EXISTS msgr.sms_sendlogs
    (
        `sms_id` UUID,
        `team_id` Nullable(UUID),
        `updated_datetime` DateTime64,
        `sms_campaign_id` Nullable(UUID),
        `sms_campaign_send_id` Nullable(UUID),
        `segment_id` Nullable(UUID),
        `contact_id` Nullable(UUID),
        `phone_normalized` Nullable(UInt64),
        `network_id` Nullable(UInt32),
        `country_id` Nullable(UInt16),
        `foreign_id` Nullable(String),
        `fail_reason` Nullable(String),
        `is_sent` Nullable(Int8),
        `is_clicked` Nullable(Int8),
        `is_lead` Nullable(Int8),
        `is_sale` Nullable(Int8),
        `conversion_profit` Nullable(Int32),
        `is_unsubscribed` Nullable(Int8),
        `unsubscribed_method` Nullable(String),
        `domain_id` Nullable(UUID),
        `shortened_url` Nullable(String),
        `offer_id` Nullable(UUID),
        `campaign_text_id` Nullable(UUID),
        `final_text` Nullable(String),
        `text_parts` Nullable(UInt8),
        `sms_routing_plan_id` Nullable(UUID),
        `sms_routing_plan_rule_id` Nullable(UUID),
        `sms_routing_route_id` Nullable(UUID),
        `sms_rule_selected_data` Nullable(String),
        `sender_id` Nullable(String),
        `sender_id_id` Nullable(UUID),
        `sms_parts` Nullable(UInt8),
        `dlr_code` Nullable(UInt8),
        `dlr_str` Nullable(String),
        `cost_platform_profit` Nullable(Decimal(18,15)),
        `cost_platform_cost` Nullable(Decimal(18,15)),
        `cost_user_vendor_cost` Nullable(Decimal(18,15)),
        `click_meta` Nullable(String),
        `sent_at` Nullable(DateTime),
        `time_clicked` Nullable(DateTime),
        `meta` Nullable(String)
    )
ENGINE = MergeTree
ORDER BY (updated_datetime, sms_id)
SETTINGS index_granularity = 8192"
        );

        static::write(
            "CREATE VIEW IF NOT EXISTS sms_sendlogs_v AS
SELECT 
    sms_id,
    anyLast(team_id) as team_id,
    max(updated_datetime) as updated_datetime,
    anyLast(sms_campaign_id) as sms_campaign_id,
    anyLast(sms_campaign_send_id) as sms_campaign_send_id,
    anyLast(segment_id) as segment_id,
    anyLast(contact_id) as contact_id,
    anyLast(phone_normalized) as phone_normalized,
    anyLast(network_id) as network_id,
    anyLast(country_id) as country_id,
    anyLast(foreign_id) as foreign_id,
    anyLast(fail_reason) as fail_reason,
    anyLast(is_sent) as is_sent,
    anyLast(is_clicked) as is_clicked,
    anyLast(is_lead) as is_lead,
    anyLast(is_sale) as is_sale,
    anyLast(conversion_profit) as conversion_profit,
    anyLast(is_unsubscribed) as is_unsubscribed,
    anyLast(unsubscribed_method) as unsubscribed_method,
    anyLast(domain_id) as domain_id,
    anyLast(shortened_url) as shortened_url,
    anyLast(offer_id) as offer_id,
    anyLast(campaign_text_id) as campaign_text_id,
    anyLast(final_text) as final_text,
    anyLast(text_parts) as text_parts,
    anyLast(sms_routing_plan_id) as sms_routing_plan_id,
    anyLast(sms_routing_plan_rule_id) as sms_routing_plan_rule_id,
    anyLast(sms_routing_route_id) as sms_routing_route_id,
    anyLast(sms_rule_selected_data) as sms_rule_selected_data,
    anyLast(sender_id) as sender_id,
    anyLast(sender_id_id) as sender_id_id,
    anyLast(sms_parts) as sms_parts,
    anyLast(dlr_code) as dlr_code,
    anyLast(dlr_str) as dlr_str,
    anyLast(cost_platform_profit) as cost_platform_profit,
    anyLast(cost_platform_cost) as cost_platform_cost,
    anyLast(cost_user_vendor_cost) as cost_user_vendor_cost,
    anyLast(click_meta) as click_meta,
    anyLast(sent_at) as sent_at,
    anyLast(time_clicked) as time_clicked,
    anyLast(meta) as meta
FROM msgr.sms_sendlogs
GROUP BY sms_id;
");

//        `list_id` SimpleAggregateFunction(anyLast, UUID),
//        static::write("
//        CREATE TABLE IF NOT EXISTS msgr.sms_sendlog_materialized
//        (
//        `team_id` UUID,
//        `first_datetime` SimpleAggregateFunction(any, DateTime),
//        `updated_datetime` SimpleAggregateFunction(anyLast, DateTime),
//        `verified_status` SimpleAggregateFunction(anyLast, String),
//        `segment_id` SimpleAggregateFunction(anyLast, UUID),
//        `contact_id` SimpleAggregateFunction(anyLast, UUID),
//        `network_id` SimpleAggregateFunction(anyLast, UUID),
//        `country_id` SimpleAggregateFunction(anyLast, UUID),
//        `campaign_send_id` SimpleAggregateFunction(anyLast, UUID),
//        `foreign_id` SimpleAggregateFunction(anyLast, String),
//        `fail_reason` SimpleAggregateFunction(anyLast, String),
//        `is_clicked` SimpleAggregateFunction(anyLast, Bool),
//        `is_lead` SimpleAggregateFunction(anyLast, Bool),
//        `is_sale` SimpleAggregateFunction(anyLast, Bool),
//        `sale_profit` SimpleAggregateFunction(anyLast, Int32),
//        `is_unsubscribed` SimpleAggregateFunction(anyLast, Bool),
//        `unsubscribed_method` SimpleAggregateFunction(anyLast, String),
//        `domain_id` SimpleAggregateFunction(anyLast, UUID),
//        `original_url` SimpleAggregateFunction(anyLast, String),
//        `shortened_url` SimpleAggregateFunction(anyLast, String),
//        `offer_id` SimpleAggregateFunction(anyLast, UUID),
//        `offer_group_id` SimpleAggregateFunction(anyLast, UUID),
//        `campaign_text_id` SimpleAggregateFunction(anyLast, UUID),
//        `final_text` SimpleAggregateFunction(anyLast, String),
//        `plan_id` SimpleAggregateFunction(anyLast, UUID),
//        `rule_id` SimpleAggregateFunction(anyLast, UUID),
//        `rule_reason` SimpleAggregateFunction(anyLast, String),
//        `sender_id` SimpleAggregateFunction(anyLast, String),
//        `sender_id_id` SimpleAggregateFunction(anyLast, UUID),
//        `sms_parts` SimpleAggregateFunction(anyLast, UInt8),
//        `dlr_code` SimpleAggregateFunction(anyLast, UInt8),
//        `dlr_str` SimpleAggregateFunction(anyLast, String),
//        `cost_platform_profit` SimpleAggregateFunction(anyLast, Decimal(18,15)),
//        `cost_platform_cost` SimpleAggregateFunction(anyLast, Decimal(18,15)),
//        `cost_user_vendor_cost` SimpleAggregateFunction(anyLast, Decimal(18,15))
//        ) engine = SummingMergeTree PRIMARY KEY id
//        ORDER BY id
//        SETTINGS index_granularity = 8192;
//        ");

        //todo after contacts branch merge
//        static::write("CREATE MATERIALIZED VIEW IF NOT EXISTS sms_sendlog_mv TO contacts_sms_materialized AS
//    select team_id,list_id,phone_normalized, sum(is_sent), sum(is_clicked) as clicks_count, sum(is_lead) as leads_count,
//    sum(is_sale) as sales_count, sum(profit) as profit_sum from sms_sendlog group by team_id,list_id,phone_normalized;");

        static::write("create table IF NOT EXISTS contacts (
    `id` UUID,
    `team_id` UUID,
    `list_id` UUID,
    `phone_normalized` UInt64,
    `phone_is_good` UInt8,
    `phone_is_good_reason` UInt8,
    `email_normalized` String,
    `email_is_good` UInt8,
    `email_is_good_reason` UInt8,
    `name` String,
    `country_id` UInt16,
    `state_id` UInt32,
    `state_id_reason` UInt8,
    `custom1_str` String,
    `custom2_str` String,
    `custom3_str` String,
    `custom4_str` String,
    `custom5_str` String,
    `custom1_int` UInt16,
    `custom2_int` UInt16,
    `custom3_int` UInt16,
    `custom4_int` UInt16,
    `custom5_int` UInt16,
    `custom1_dec` Decimal(18,15),
    `custom2_dec` Decimal(18,15),
    `custom1_datetime` DateTime,
    `custom2_datetime` DateTime,
    `custom3_datetime` DateTime,
    `custom4_datetime` DateTime,
    `custom5_datetime` DateTime,
    `date_updated` DateTime,
    `meta` String,
    `is_deleted` Bool
)ENGINE = MergeTree
ORDER BY (team_id)
SETTINGS index_granularity = 8192");

        /**
         *
         * //    `email_normalized` SimpleAggregateFunction(anyLast, String),
         * //    `email_is_good` SimpleAggregateFunction(anyLast,UInt8),
         * //    `email_is_good_reason` SimpleAggregateFunction(anyLast,UInt8),
         */
        static::write('create table IF NOT EXISTS contacts_sms_materialized
(
    `team_id` UUID,
    `list_id` UUID,
    `phone_normalized` UInt64,
    `last_sent` SimpleAggregateFunction(anyLast, DATETIME),
    `last_clicked` SimpleAggregateFunction(anyLast, DATETIME),
    `sent_count` SimpleAggregateFunction(sum, UInt64),
    `clicked_count` SimpleAggregateFunction(sum, UInt64),
    `leads_count` SimpleAggregateFunction(sum, UInt64),
    `sales_count` SimpleAggregateFunction(sum, UInt64),
    `profit_sum` SimpleAggregateFunction(sum, UInt64),
    `network_brand` SimpleAggregateFunction(anyLast, String),
    `network_id` SimpleAggregateFunction(anyLast,UInt8),
    `network_reason` SimpleAggregateFunction(anyLast,UInt8),
    `phone_is_good` SimpleAggregateFunction(anyLast,UInt8),
    `phone_is_good_reason` SimpleAggregateFunction(anyLast,UInt8),
    `name` SimpleAggregateFunction(anyLast,String),
    `country_id` SimpleAggregateFunction(anyLast,UInt16),
    `state_id` SimpleAggregateFunction(anyLast,UInt32),
    `state_id_reason` SimpleAggregateFunction(anyLast,UInt8),
    `custom1_str` SimpleAggregateFunction(anyLast,String),
    `custom2_str` SimpleAggregateFunction(anyLast,String),
    `custom3_str` SimpleAggregateFunction(anyLast,String),
    `custom4_str` SimpleAggregateFunction(anyLast,String),
    `custom5_str` SimpleAggregateFunction(anyLast,String),
    `custom1_int` SimpleAggregateFunction(anyLast,UInt16),
    `custom2_int` SimpleAggregateFunction(anyLast,UInt16),
    `custom3_int` SimpleAggregateFunction(anyLast,UInt16),
    `custom4_int` SimpleAggregateFunction(anyLast,UInt16),
    `custom5_int` SimpleAggregateFunction(anyLast,UInt16),
    `custom1_dec` SimpleAggregateFunction(anyLast,Decimal(18,15)),
    `custom2_dec` SimpleAggregateFunction(anyLast,Decimal(18,15)),
    `custom1_datetime` SimpleAggregateFunction(anyLast,DateTime),
    `custom2_datetime` SimpleAggregateFunction(anyLast,DateTime),
    `custom3_datetime` SimpleAggregateFunction(anyLast,DateTime),
    `custom4_datetime` SimpleAggregateFunction(anyLast,DateTime),
    `custom5_datetime` SimpleAggregateFunction(anyLast,DateTime),
    `date_updated` SimpleAggregateFunction(anyLast,DateTime),
    `date_created` SimpleAggregateFunction(any,DateTime),
    `is_deleted` SimpleAggregateFunction(anyLast,Bool)
)
    engine = SummingMergeTree
        ORDER BY (team_id, country_id, list_id, network_brand, phone_normalized, phone_is_good)
        SETTINGS index_granularity = 8192;
');


//        static::write("CREATE MATERIALIZED VIEW IF NOT EXISTS contacts_mv TO contacts_sms_materialized AS
//    select team_id, list_id, phone_normalized,
//    anyLast(custom1_str),
//    anyLast(custom2_str), anyLast(custom3_str),
//     anyLast(custom4_str), anyLast(custom5_str),
//      anyLast(custom1_int), anyLast(custom2_int),
//       anyLast(custom3_int), anyLast(custom4_int),
//        anyLast(custom5_int), anyLast(custom1_dec),
//        anyLast(custom2_dec), anyLast(custom1_datetime),
//        anyLast(custom2_datetime), anyLast(custom3_datetime),
//        anyLast(custom4_datetime), anyLast(custom5_datetime),
//         anyLast(meta), anyLast(is_deleted),
//         anyLast(phone_is_good),  anyLast(phone_is_good_reason),
//         anyLast(name), anyLast(country_id),
//         anyLast(state_id), anyLast(state_id_reason)
//    from contacts group by team_id, list_id, phone_normalized;");

        static::write('create table IF NOT EXISTS contact_tags
(
    team_id UUID,
    contact_id UUID,
    tag String,
    date_created DateTime,
    is_deleted Bool default 0
)ENGINE = MergeTree
    ORDER BY (team_id, contact_id, tag)
SETTINGS index_granularity = 8192');

        static::write('create table IF NOT EXISTS contact_tags_materialized
(
    team_id UUID,
    tag String,
    contact_id UUID,
    is_deleted SimpleAggregateFunction(anyLast,Bool)
)ENGINE = SummingMergeTree
ORDER BY (team_id, tag, contact_id)
SETTINGS index_granularity = 8192');

        static::write("CREATE MATERIALIZED VIEW IF NOT EXISTS contact_tags_mv TO contact_tags_materialized AS
    select team_id, tag, contact_id, max(is_deleted) from contact_tags group by team_id, contact_id, tag;");

        static::write('create table IF NOT EXISTS action_log
(
    id UUID,
    team_id UUID,
    user_id UUID,
    type String,
    related_model UUID,
    text String,
    date_created DateTime DEFAULT now(),
    meta String
        ) ENGINE = MergeTree
ORDER BY (team_id, related_model, date_created)
TTL date_created + INTERVAL 12 MONTH
SETTINGS index_granularity = 8192');

        static::write("create table IF NOT EXISTS balances
(
    id UUID,
    team_id UUID,
    amount DECIMAL64(6),
    meta Nullable(String),
    date_created DateTime DEFAULT now()
) ENGINE = MergeTree
    ORDER BY (team_id)
");

        static::write("create table IF NOT EXISTS balances_teams_materialized
(
    team_id UUID,
    balance SimpleAggregateFunction(sumWithOverflow(), DECIMAL64(6))
) ENGINE = SummingMergeTree
    ORDER BY (team_id)
");
        static::write('create materialized view IF NOT EXISTS balances_teams_mv TO balances_teams_materialized AS
        select team_id, sum(amount) as balance from balances group by team_id
        ');
        static::write('create view IF NOT EXISTS balances_teams_v AS
        select team_id, sum(balance) as balance from balances_teams_materialized group by team_id
        ');

        static::write("create table IF NOT EXISTS v2_contact_unsub_manual (
    `team_id` UUID,
    `unsub_list_id` UUID DEFAULT '00000000-0000-0000-0000-000000000000',
    `phone_normalized` UInt64,
    `date_updated` DateTime,
    `is_deleted` Bool comment 'if removed can be sent again'
)ENGINE = MergeTree
ORDER BY (team_id,unsub_list_id)
SETTINGS index_granularity = 8192");

        static::write("create table IF NOT EXISTS v2_contact_unsub_manual_materialized (
    `team_id` UUID,
    `unsub_list_id` UUID,
    `phone_normalized` UInt64,
    `date_updated` AggregateFunction(anyLast, DateTime),
    `is_deleted` AggregateFunction(anyLast, Bool)
)ENGINE = SummingMergeTree
ORDER BY (team_id, unsub_list_id)
SETTINGS index_granularity = 8192
");

        static::write("CREATE MATERIALIZED VIEW IF NOT EXISTS v2_contact_unsub_manual_mv TO v2_contact_unsub_manual_materialized AS
    select team_id,unsub_list_id, phone_normalized, max(date_updated),max(is_deleted) from v2_contact_unsub_manual group by team_id,unsub_list_id,phone_normalized;");

        static::write("
CREATE TABLE IF NOT EXISTS msgr.lookup_result
(
    `id` UInt64,
    `check_id` UInt64,
    `request_id` UInt64,
    `callback_id` Nullable(UInt64),
    `callback_code` String,
    `status` UInt32,
    `number` UInt64,
    `number_id` UInt64,
    `provider_price` Decimal(18,
 15),
    `admin_price` Decimal(18,
 15),
    `lookup_type` UInt32,
    `verified` UInt8,
    `network_id` Nullable(UInt32),
    `created_at` DateTime,
    `updated_at` Nullable(DateTime)
)
ENGINE = MergeTree
PARTITION BY toYYYYMM(created_at)
PRIMARY KEY (id,
 created_at)
ORDER BY (id,
 created_at)
SETTINGS index_granularity = 8192;
        ");

        static::write("
        CREATE TABLE if not exists msgr.v2_numbers_networks
        (
            `normalized` UInt64,
            `network_id` SimpleAggregateFunction(anyLast, UInt32),
            `network_brand` SimpleAggregateFunction(anyLast, String),
            `network_brand_group` SimpleAggregateFunction(anyLast, String),
            `lookup_priority` SimpleAggregateFunction(anyLast, UInt8),
            `updated` SimpleAggregateFunction(anyLast, DateTime)
        )
        ENGINE = SummingMergeTree()
        ORDER BY normalized;
        ");

        static::write('CREATE MATERIALIZED VIEW IF NOT EXISTS msgr.sms_contact_sms_networks_mv TO msgr.contacts_sms_materialized
        (
         `phone_normalized` UInt64,
         `team_id` UUID,
         `network_id` SimpleAggregateFunction(anyLast, Nullable(UInt32)),
         `network_brand` SimpleAggregateFunction(anyLast, Nullable(String))
            ) AS
SELECT
    csm.phone_normalized,
    csm.team_id,
    vnn.network_id AS network_id,
    vnn.network_brand AS network_brand
FROM msgr.v2_numbers_networks AS vnn
         INNER JOIN msgr.contacts_sms_materialized AS csm ON phone_normalized = normalized
WHERE csm.network_id IS NULL;');

        static::write("
CREATE TABLE IF NOT EXISTS v2_mobile_networks
(
    `id` UInt32,
    `mcc` UInt32,
    `mnc` UInt32,
    `type` String,
    `country_name` String,
    `country_code` String,
    `country_id` UInt32,
    `brand` String,
    `operator` String,
    `status` String,
    `bands` String,
    `notes` String
)
ENGINE = MergeTree()
ORDER BY (id, country_id)
SETTINGS index_granularity = 8192;
");
        $this->insertMobileNetworks();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        return;
    }

    public function insertMobileNetworks()
    {
        static::write("
        INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8624,289,67,'National','Abkhazia','GE-AB',0,'Aquafon','Aquafon JSC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','MCC is not listed by ITU; LTE band 20'),
	 (8625,289,88,'National','Abkhazia','GE-AB',0,'A-Mobile','A-Mobile LLSC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','MCC is not listed by ITU'),
	 (8626,412,1,'National','Afghanistan','AF',1,'AWCC','Afghan Wireless Communication Company','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8627,412,20,'National','Afghanistan','AF',1,'Roshan','Telecom Development Company Afghanistan Ltd.','Operational','GSM 900 / UMTS',''),
	 (8628,412,40,'National','Afghanistan','AF',1,'MTN','MTN Group Afghanistan','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8629,412,50,'National','Afghanistan','AF',1,'Etisalat','Etisalat Afghanistan','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8630,412,55,'National','Afghanistan','AF',1,'WASEL','WASEL Afghanistan','Operational','CDMA 800',''),
	 (8631,412,80,'National','Afghanistan','AF',1,'Salaam','Afghan Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8632,412,88,'National','Afghanistan','AF',1,'Salaam','Afghan Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8633,276,1,'National','Albania','AL',2,'Telekom.al','Telekom Albania','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8634,276,2,'National','Albania','AL',2,'Vodafone','Vodafone Albania','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (8635,276,3,'National','Albania','AL',2,'Eagle Mobile','Albtelecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8636,276,4,'National','Albania','AL',2,'Plus Communication','Plus Communication','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8637,603,1,'National','Algeria','DZ',3,'Mobilis','Algérie Télécom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8638,603,2,'National','Algeria','DZ',3,'Djezzy','Optimum Telecom Algérie Spa','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Orascom Telecom'),
	 (8639,603,3,'National','Algeria','DZ',3,'Ooredoo','Wataniya Telecom Algérie','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Nedjma'),
	 (8640,603,7,'National','Algeria','DZ',3,'AT','Algérie Télécom','Operational','CDMA 1900','Wireless Local Loop'),
	 (8641,603,9,'National','Algeria','DZ',3,'AT','Algérie Télécom','Operational','LTE','Fixed Wireless Broadband'),
	 (8642,603,21,'National','Algeria','DZ',3,'ANESRIF','Anesrif','Ongoing','GSM-R',''),
	 (8643,544,11,'National','American Samoa (United States of America)','AS',4,'Bluesky','Bluesky','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 700 / LTE 1700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8644,213,3,'National','Andorra','AD',5,'Mobiland','Servei De Tele. DAndorra','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','LTE band 20'),
	 (8645,631,2,'National','Angola','AO',6,'UNITEL','UNITEL S.a.r.l.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8646,631,4,'National','Angola','AO',6,'MOVICEL','MOVICEL Telecommunications S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 1800','CDMA shut down March 2016'),
	 (8647,365,10,'National','Anguilla (United Kingdom)','AI',7,'','Weblinks Limited','Operational','Unknown',''),
	 (8648,365,840,'National','Anguilla (United Kingdom)','AI',7,'FLOW','Cable & Wireless','Operational','GSM 850 / UMTS / LTE 700',''),
	 (8649,344,30,'National','Antigua and Barbuda','AG',9,'APUA','Antigua Public Utilities Authority','Operational','GSM 1900',''),
	 (8650,344,50,'National','Antigua and Barbuda','AG',9,'Digicel','Antigua Wireless Ventures Limited','Operational','GSM 900 / GSM 1900 / UMTS 850 / LTE 700','LTE band 17'),
	 (8651,344,920,'National','Antigua and Barbuda','AG',9,'FLOW','Cable & Wireless Caribbean Cellular (Antigua) Limited','Operational','GSM 850 / GSM 1800 / GSM 1900 / UMTS / LTE 1700',''),
	 (8652,344,930,'National','Antigua and Barbuda','AG',9,'AT&T','AT&T Wireless','Unknown','Unknown',''),
	 (8653,722,10,'National','Argentina','AR',10,'Movistar','Telefónica Móviles Argentina S.A.','Operational','GSM 850 / GSM 1900 / UMTS / LTE 1700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8654,722,20,'National','Argentina','AR',10,'Nextel','NII Holdings','Operational','iDEN 800',''),
	 (8655,722,34,'National','Argentina','AR',10,'Personal','Telecom Personal S.A.','Operational','Unknown',''),
	 (8656,722,40,'National','Argentina','AR',10,'Globalstar','TE.SA.M Argentina S.A.','Operational','Unknown',''),
	 (8657,722,70,'National','Argentina','AR',10,'Movistar','Telefónica Móviles Argentina S.A.','Operational','GSM 1900',''),
	 (8658,722,310,'National','Argentina','AR',10,'Claro','AMX Argentina S.A.','Operational','GSM 1900',''),
	 (8659,722,320,'National','Argentina','AR',10,'Claro','AMX Argentina S.A.','Operational','GSM 850 / GSM 1900 / UMTS / LTE 1700',''),
	 (8660,722,330,'National','Argentina','AR',10,'Claro','AMX Argentina S.A.','Operational','GSM 850 / GSM 1900 / UMTS / LTE 1700',''),
	 (8661,722,341,'National','Argentina','AR',10,'Personal','Telecom Personal S.A.','Operational','GSM 850 / GSM 1900 / UMTS / LTE 700 / LTE 1700 / LTE 2600','LTE bands 28 / 4 / 7'),
	 (8662,722,350,'National','Argentina','AR',10,'PORT-HABLE','Hutchison Telecommunications Argentina S.A.','Not operational','GSM 900','Acquired by Claro'),
	 (8663,283,1,'National','Armenia','AM',11,'Beeline','ArmenTel','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 450 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8664,283,4,'National','Armenia','AM',11,'Karabakh Telecom','Karabakh Telecom','Operational','GSM 900 / UMTS 900',''),
	 (8665,283,5,'National','Armenia','AM',11,'VivaCell-MTS','K Telecom CJSC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600',''),
	 (8666,283,10,'National','Armenia','AM',11,'Ucom','Ucom LLC','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800','Former Orange'),
	 (8667,363,1,'National','Aruba (Kingdom of the Netherlands)','AW',12,'SETAR','Servicio di Telecomunicacion di Aruba','Operational','GSM 900 / GSM 1800 / GSM 1900 / UMTS 2100 / LTE 1800 / TDMA 800',''),
	 (8668,363,2,'National','Aruba (Kingdom of the Netherlands)','AW',12,'Digicel','Digicel Aruba','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8669,505,1,'National','Australia','AU',13,'Telstra','Telstra Corporation Limited','Operational','UMTS 850 / UMTS 2100 / LTE 700 / LTE 900 / LTE 1800 / LTE 2100','LTE bands 28 / 8 / 3 / 1; GSM was closed on 1 December 2016'),
	 (8670,505,2,'National','Australia','AU',13,'Optus','Singtel Optus Proprietary Limited','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2100 / TD-LTE 2300','LTE bands 28 / 3 / 1 / 40; GSM was closed on 1 August 2017'),
	 (8671,505,3,'National','Australia','AU',13,'Vodafone','Vodafone','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 900 / UMTS 2100 / LTE 850 / LTE 1800 / LTE 2100','LTE bands 5 / 3 / 1; GSM to shut down 30 September 2017'),
	 (8672,505,4,'National','Australia','AU',13,'','Department of Defence','Operational','Unknown','Private network'),
	 (8673,505,5,'National','Australia','AU',13,'Ozitel','Ozitel','Not operational','','Brand was taken over by Telstra.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8674,505,6,'National','Australia','AU',13,'3','Vodafone','Not operational','UMTS 2100','Vodafone Hutchison Australia and Telstra ended their network sharing agreement on 31 August 2012. The 3TELSTRA network was shut down on this date.'),
	 (8675,505,7,'National','Australia','AU',13,'Vodafone','Vodafone','Unknown','Unknown',''),
	 (8676,505,8,'National','Australia','AU',13,'One.Tel','One.Tel Limited','Not operational','GSM 900','Brand was dissolved.'),
	 (8677,505,9,'National','Australia','AU',13,'Airnet','Airnet','Not operational','','No longer provide mobile services.'),
	 (8678,505,10,'National','Australia','AU',13,'Norfolk Is.','Norfolk Telecom','Operational','GSM 900',''),
	 (8679,505,11,'National','Australia','AU',13,'Telstra','Telstra Corporation Limited','Unknown','Unknown',''),
	 (8680,505,12,'National','Australia','AU',13,'3','Vodafone','Not operational','UMTS 2100','See MNC 06'),
	 (8681,505,13,'National','Australia','AU',13,'RailCorp','Railcorp, Transport for New South Wales','Operational','GSM-R 1800','For use by Sydney Trains Digital Train Radio System'),
	 (8682,505,14,'National','Australia','AU',13,'AAPT','TPG Telecom','Operational','MVNO','Wholesale from Vodafone Hutchison Australia'),
	 (8683,505,15,'National','Australia','AU',13,'3GIS','3GIS','Not operational','','Taken over by Vodafone.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8684,505,16,'National','Australia','AU',13,'VicTrack','Victorian Rail Track','Operational','GSM-R 1800','Digital Train Radio System'),
	 (8685,505,17,'National','Australia','AU',13,'','Optus','Unknown','TD-LTE 2300','Former Vivid Wireless Pty. Ltd.'),
	 (8686,505,18,'National','Australia','AU',13,'Pactel','Pactel International Pty Ltd','Unknown','',''),
	 (8687,505,19,'National','Australia','AU',13,'Lycamobile','Lycamobile Pty Ltd','Operational','MVNO',''),
	 (8688,505,20,'National','Australia','AU',13,'','Ausgrid Corporation','Unknown','Unknown',''),
	 (8689,505,21,'National','Australia','AU',13,'','Queensland Rail Limited','Unknown','GSM-R 1800',''),
	 (8690,505,22,'National','Australia','AU',13,'','iiNet Ltd','Unknown','Unknown',''),
	 (8691,505,23,'National','Australia','AU',13,'','Challenge Networks Pty. Ltd.','Planning','LTE 2100',''),
	 (8692,505,24,'National','Australia','AU',13,'','Advanced Communications Technologies Pty. Ltd.','Unknown','Unknown',''),
	 (8693,505,25,'National','Australia','AU',13,'','Pilbara Iron Company Services Pty Ltd','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8694,505,26,'National','Australia','AU',13,'','Dialogue Communications Pty. Ltd.','Unknown','Unknown',''),
	 (8695,505,27,'National','Australia','AU',13,'','Nexium Telecommunications','Unknown','Unknown',''),
	 (8696,505,28,'National','Australia','AU',13,'','RCOM International Pty Ltd','Unknown','Unknown',''),
	 (8697,505,30,'National','Australia','AU',13,'','Compatel Limited','Unknown','Unknown',''),
	 (8698,505,31,'National','Australia','AU',13,'','BHP Billiton','Unknown','Unknown',''),
	 (8699,505,32,'National','Australia','AU',13,'','Thales Australia','Unknown','Unknown',''),
	 (8700,505,33,'National','Australia','AU',13,'','CLX Networks Pty Ltd','Unknown','Unknown',''),
	 (8701,505,34,'National','Australia','AU',13,'','Santos Limited','Unknown','Unknown',''),
	 (8702,505,35,'National','Australia','AU',13,'','MessageBird Pty Ltd','Unknown','Unknown',''),
	 (8703,505,36,'National','Australia','AU',13,'Optus','Optus Mobile Pty. Ltd.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8704,505,37,'National','Australia','AU',13,'','Yancoal Australia Ltd','Unknown','Unknown',''),
	 (8705,505,38,'National','Australia','AU',13,'Truphone','Truphone Pty Ltd','Operational','MVNO','Formerly Crazy John''s'),
	 (8706,505,39,'National','Australia','AU',13,'Telstra','Telstra Corporation Limited','Unknown','Unknown',''),
	 (8707,505,40,'National','Australia','AU',13,'','CITIC Pacific Mining','Unknown','Unknown',''),
	 (8708,505,41,'National','Australia','AU',13,'','Aqura Technologies Pty','Unknown','Unknown','Former OTOC'),
	 (8709,505,42,'National','Australia','AU',13,'GEMCO','Groote Eylandt Mining Company Pty Ltd','Unknown','Unknown',''),
	 (8710,505,43,'National','Australia','AU',13,'','Arrow Energy Pty Ltd','Unknown','Unknown',''),
	 (8711,505,44,'National','Australia','AU',13,'','Roy Hill Iron Ore Pty Ltd','Unknown','Unknown',''),
	 (8712,505,50,'National','Australia','AU',13,'','Pivotel Group Pty Limited','Operational','Satellite',''),
	 (8713,505,61,'National','Australia','AU',13,'CommTel NS','Commtel Network Solutions Pty Ltd','Implement / Design','LTE 1800 / LTE 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8714,505,62,'National','Australia','AU',13,'NBN','National Broadband Network Co.','Operational','TD-LTE 2300','LTE band 40'),
	 (8715,505,68,'National','Australia','AU',13,'NBN','National Broadband Network Co.','Operational','TD-LTE 2300','LTE band 40'),
	 (8716,505,71,'National','Australia','AU',13,'Telstra','Telstra Corporation Limited','Operational','Unknown',''),
	 (8717,505,72,'National','Australia','AU',13,'Telstra','Telstra Corporation Limited','Operational','Unknown',''),
	 (8718,505,88,'National','Australia','AU',13,'','Pivotel Group Pty Limited','Operational','Satellite','Former Localstar Holding Pty. Ltd.'),
	 (8719,505,90,'National','Australia','AU',13,'Optus','Singtel Optus Proprietary Limited','Operational','Unknown',''),
	 (8720,505,99,'National','Australia','AU',13,'One.Tel','One.Tel','Not operational','GSM 1800','Brand was dissolved. Rail operators purchased 1800 spectrum.'),
	 (8721,232,1,'National','Austria','AT',14,'A1.net','A1 Telekom Austria','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 2600','former A1 / Mobilkom / PTA'),
	 (8722,232,2,'National','Austria','AT',14,'','A1 Telekom Austria','Reserved','',''),
	 (8723,232,3,'National','Austria','AT',14,'T-Mobile AT','T-Mobile Austria','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','former Max.Mobil / national roaming agreement with 232-10');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8724,232,4,'National','Austria','AT',14,'T-Mobile AT','T-Mobile Austria Gmbh','Unknown','Unknown',''),
	 (8725,232,5,'National','Austria','AT',14,'3','Hutchison Drei Austria','Operational','GSM 900 / UMTS 2100','owned by Hutchison Drei Austria / former Orange Austria / One / Connect'),
	 (8726,232,6,'National','Austria','AT',14,'Orange AT','Orange Austria GmbH','Not operational','Unknown','MNC withdrawn'),
	 (8727,232,7,'National','Austria','AT',14,'tele.ring','T-Mobile Austria','Operational','MVNO','brand of T-Mobile Austria'),
	 (8728,232,8,'National','Austria','AT',14,'Lycamobile','Lycamobile Austria','Operational','MVNO',''),
	 (8729,232,9,'National','Austria','AT',14,'Tele2Mobil','A1 Telekom Austria','Operational','MVNO','division bought from Tele2 by A1 Telekom Austria; customers \"moved\" to bob (232-11)'),
	 (8730,232,10,'National','Austria','AT',14,'3','Hutchison Drei Austria','Operational','UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100 / LTE 2600','national roaming agreement with 232-03, one-way national roaming agreement with 232-01'),
	 (8731,232,11,'National','Austria','AT',14,'bob','A1 Telekom Austria','Operational','MVNO','brand of A1 Telekom Austria'),
	 (8732,232,12,'National','Austria','AT',14,'yesss!','A1 Telekom Austria','Operational','MVNO','owned by A1 Telekom Austria / one-way national roaming agreement with 232-05'),
	 (8733,232,13,'National','Austria','AT',14,'upc','UPC Austria','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8734,232,14,'National','Austria','AT',14,'','Hutchison Drei Austria','Reserved','Unknown',''),
	 (8735,232,15,'National','Austria','AT',14,'Vectone Mobile','Mundio Mobile Austria','Operational','MVNO','former Barablu Mobile Austria, uses A1'),
	 (8736,232,16,'National','Austria','AT',14,'','Hutchison Drei Austria','Reserved','Unknown',''),
	 (8737,232,17,'National','Austria','AT',14,'','MASS Response Service GmbH','Unknown','Unknown',''),
	 (8738,232,18,'National','Austria','AT',14,'','smartspace GmbH','Unknown','MVNO',''),
	 (8739,232,19,'National','Austria','AT',14,'','Tele2 Telecommunication GmbH','Unknown','Unknown',''),
	 (8740,232,20,'National','Austria','AT',14,'m:tel','MTEL Austrija GmbH','Operational','MVNO',''),
	 (8741,232,21,'National','Austria','AT',14,'','Salzburg AG für Energie, Verkehr und Telekommunikation','Unknown','Unknown',''),
	 (8742,232,22,'National','Austria','AT',14,'','Plintron Austria Limited','Unknown','MVNO',''),
	 (8743,232,23,'National','Austria','AT',14,'T-Mobile','T-Mobile Austria GmbH','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8744,232,91,'National','Austria','AT',14,'GSM-R A','ÖBB','Operational','GSM-R','railways communication'),
	 (8745,232,92,'National','Austria','AT',14,'ArgoNET','ArgoNET GmbH','Operational','CDMA450 / LTE450','machine to machine communication for critical infrastructure'),
	 (8746,400,1,'National','Azerbaijan','AZ',15,'Azercell','','Operational','GSM 900 / GSM 1800/ UMTS 2100 / LTE 1800',''),
	 (8747,400,2,'National','Azerbaijan','AZ',15,'Bakcell','','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8748,400,3,'National','Azerbaijan','AZ',15,'FONEX','CATEL','Operational','CDMA 450',''),
	 (8749,400,4,'National','Azerbaijan','AZ',15,'Nar Mobile','Azerfon','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8750,400,5,'National','Azerbaijan','AZ',15,'','Special State Protection Service of the Republic of Azerbaijan','Unknown','TETRA?',''),
	 (8751,400,6,'National','Azerbaijan','AZ',15,'Naxtel','Nakhtel LLC','Operational','CDMA 800',''),
	 (8752,364,39,'National','Bahamas','BS',16,'BTC','The Bahamas Telecommunications Company Ltd (BaTelCo)','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 700','LTE band 17'),
	 (8753,364,49,'National','Bahamas','BS',16,'Aliv','Cable Bahamas Ltd','Operational','LTE 700 / LTE AWS','Former NewCo 2015; LTE bands 13 / 4, license also covers 850MHz and 1900MHz');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8754,426,1,'National','Bahrain','BH',17,'Batelco','Bahrain Telecommunications Company','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8755,426,2,'National','Bahrain','BH',17,'zain BH','Zain Bahrain','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8756,426,3,'National','Bahrain','BH',17,'','Civil Aviation Authority','Unknown','Unknown',''),
	 (8757,426,4,'National','Bahrain','BH',17,'VIVA Bahrain','Viva Bahrain','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8758,426,5,'National','Bahrain','BH',17,'Batelco','Bahrain Telecommunications Company','Operational','GSM 900 / GSM 1800','Royal Court use only'),
	 (8759,470,1,'National','Bangladesh','BD',18,'Grameenphone','Grameenphone Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8760,470,2,'National','Bangladesh','BD',18,'Robi','Axiata Bangladesh Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800','Formerly Aktel'),
	 (8761,470,3,'National','Bangladesh','BD',18,'Banglalink','Banglalink Digital Communications Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','VEON'),
	 (8762,470,4,'National','Bangladesh','BD',18,'TeleTalk','Teletalk Bangladesh Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8763,470,5,'National','Bangladesh','BD',18,'Citycell','Pacific Bangladesh Telecom Limited','Not operational','CDMA 800','Shutdown by Bangladesh Telecommunication Regulatory Commission in 2016');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8764,470,7,'National','Bangladesh','BD',18,'Airtel','Bharti Airtel Bangladesh Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100','Formerly Warid Telcom, later Airtel. Currently merged with Robi keeping brand name Airtel'),
	 (8765,470,9,'National','Bangladesh','BD',18,'ollo','Bangladesh Internet Exchange Limited (BIEL)','Operational','LTE 800 / LTE 2600 / WiMAX 3500',''),
	 (8766,342,600,'National','Barbados','BB',19,'FLOW','LIME (formerly known as Cable & Wireless)','Operational','GSM 1900 / UMTS 850 / LTE 850 / LTE 1900','LTE bands 5 / 2'),
	 (8767,342,750,'National','Barbados','BB',19,'Digicel','Digicel (Barbados) Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 700 / LTE 1900','LTE bands 17 / 2'),
	 (8768,342,800,'National','Barbados','BB',19,'Ozone','Ozone Wireless Inc.','Operational','LTE 700','LTE band 13'),
	 (8769,342,820,'National','Barbados','BB',19,'','Sunbeach Communications','Not operational','Unknown',''),
	 (8770,257,1,'National','Belarus','BY',20,'velcom','','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100',''),
	 (8771,257,2,'National','Belarus','BY',20,'MTS','Mobile TeleSystems','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100','LTE via beCloud'),
	 (8772,257,3,'National','Belarus','BY',20,'DIALLOG','BelCel','Not operational','CDMA 450','Closed on 21 January 2014'),
	 (8773,257,4,'National','Belarus','BY',20,'life:)','Belarusian Telecommunications Network','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former BeST; LTE via beCloud');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8774,257,5,'National','Belarus','BY',20,'byfly','Beltelecom','Not operational','WiMAX 3500','Closed on 01 May 2017'),
	 (8775,257,6,'National','Belarus','BY',20,'beCloud','Belorussian Cloud Technologies','Operational','LTE 1800 / LTE 2600','Former Yota Bel; wholesale network used by MTS and life:)'),
	 (8776,206,0,'National','Belgium','BE',21,'Proximus','Belgacom Mobile','Not operational','Unknown','MNC withdrawn'),
	 (8777,206,1,'National','Belgium','BE',21,'Proximus','Belgacom Mobile','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (8778,206,2,'National','Belgium','BE',21,'','Infrabel','Operational','GSM-R',''),
	 (8779,206,5,'National','Belgium','BE',21,'Telenet','Telenet','Operational','MVNO','MVNO using Orange''s Network'),
	 (8780,206,6,'National','Belgium','BE',21,'Lycamobile','Lycamobile sprl','Operational','MVNO',''),
	 (8781,206,7,'National','Belgium','BE',21,'Vectone Mobile','Mundio Mobile Belgium nv','Reserved','MVNO',''),
	 (8782,206,8,'National','Belgium','BE',21,'','Nethys','Unknown','Unknown',''),
	 (8783,206,9,'National','Belgium','BE',21,'Voxbone','Voxbone mobile','Not operational','MVNO','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8784,206,10,'National','Belgium','BE',21,'Orange','Orange S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Mobistar'),
	 (8785,206,15,'National','Belgium','BE',21,'','Elephant Talk Communications Schweiz GmbH','Not operational','Unknown','MNC withdrawn'),
	 (8786,206,16,'National','Belgium','BE',21,'','NextGen Mobile Ltd.','Not operational','Unknown','MNC withdrawn'),
	 (8787,206,20,'National','Belgium','BE',21,'BASE','Telenet','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (8788,206,25,'National','Belgium','BE',21,'','Voyacom SPRL','Unknown','LTE 2600',''),
	 (8789,206,28,'National','Belgium','BE',21,'','BICS','Unknown','Unknown',''),
	 (8790,206,30,'National','Belgium','BE',21,'Mobile Vikings','Unleashed NV','Unknown','Unknown',''),
	 (8791,206,33,'National','Belgium','BE',21,'','Ericsson NV','Unknown','Unknown','Test network'),
	 (8792,206,40,'National','Belgium','BE',21,'JOIN','JOIN Experience (Belgium)','Operational','MVNO',''),
	 (8793,206,50,'National','Belgium','BE',21,'','IP Nexia','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8794,702,67,'National','Belize','BZ',22,'DigiCell','Belize Telemedia Limited (BTL)','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 700 / LTE 1900','LTE bands 17 / 2'),
	 (8795,702,68,'National','Belize','BZ',22,'INTELCO','International Telecommunications Ltd.','Not operational','Unknown','MNC withdrawn'),
	 (8796,702,69,'National','Belize','BZ',22,'SMART','Speednet Communications Limited','Operational','CDMA2000 850 / LTE 700','LTE band 13'),
	 (8797,702,99,'National','Belize','BZ',22,'SMART','Speednet Communications Limited','Operational','CDMA2000 850',''),
	 (8798,616,1,'National','Benin','BJ',23,'Libercom','Benin Telecoms Mobile','Operational','GSM 900 / GSM 1800 / LTE 1800 / CDMA / WiMAX','Brands are Libercom (GSM), be.Telecoms (LTE), Kanakoo (CDMA / WiMAX)'),
	 (8799,616,2,'National','Benin','BJ',23,'Moov','Telecel Benin','Operational','GSM 900 / UMTS','EtiSalat / Atlantique Telecom / Moov'),
	 (8800,616,3,'National','Benin','BJ',23,'MTN','Spacetel Benin','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100','Former BeninCell, Areeba'),
	 (8801,616,4,'National','Benin','BJ',23,'BBCOM','Bell Benin Communications','Operational','GSM 900 / GSM 1800',''),
	 (8802,616,5,'National','Benin','BJ',23,'Glo','Glo Communication Benin','Operational','GSM 900 / GSM 1800',''),
	 (8803,310,59,'National','Bermuda','BM',24,'Cellular One','','Operational','CDMA','uses USA MCC');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8804,338,50,'National','Bermuda','BM',24,'Digicel Bermuda','','Operational','GSM 1900 / UMTS 1900 / LTE 1900','uses Jamaica MCC'),
	 (8805,350,0,'National','Bermuda','BM',24,'CellOne','Bermuda Digital Communications Ltd.','Operational','GSM 1900 / UMTS 850 / LTE 850',''),
	 (8806,350,1,'National','Bermuda','BM',24,'Digicel Bermuda','Telecommunications (Bermuda & West Indies) Ltd','Reserved','GSM 1900',''),
	 (8807,350,2,'National','Bermuda','BM',24,'Mobility','M3 Wireless','Operational','GSM 1900 / UMTS',''),
	 (8808,350,5,'National','Bermuda','BM',24,'','Telecom Networks','Unknown','Unknown',''),
	 (8809,350,11,'National','Bermuda','BM',24,'','Deltronics','Unknown','Unknown',''),
	 (8810,402,11,'National','Bhutan','BT',25,'B-Mobile','B-Mobile / Bhutan Telecom Ltd.','Operational','GSM 900 / UMTS 850 / UMTS 2100 / LTE 1800',''),
	 (8811,402,77,'National','Bhutan','BT',25,'TashiCell','Tashi InfoComm Limited','Operational','GSM 900 / GSM 1800 / UMTS / LTE 700','LTE band 28'),
	 (8812,736,1,'National','Bolivia','BO',26,'Viva','Nuevatel PCS De Bolivia SA','Operational','GSM 1900 / UMTS / LTE 1700',''),
	 (8813,736,2,'National','Bolivia','BO',26,'Entel','Entel SA','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8814,736,3,'National','Bolivia','BO',26,'Tigo','Telefónica Celular De Bolivia S.A','Operational','GSM 850 / UMTS / LTE 700','Aka. Telecel Bolivia'),
	 (8815,218,3,'National','Bosnia and Herzegovina','BA',27,'HT-ERONET','Public Enterprise Croatian Telecom Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8816,218,5,'National','Bosnia and Herzegovina','BA',27,'m:tel BiH','RS Telecommunications JSC Banja Luka','Operational','GSM 900 / GSM 1800 / UMTS 2100','GSM-MS1, Mobilna Srpske, Mobi''s'),
	 (8817,218,90,'National','Bosnia and Herzegovina','BA',27,'BH Mobile','BH Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8818,652,1,'National','Botswana','BW',28,'Mascom','Mascom Wireless (Pty) Limited','Operational','GSM 900 / UMTS / LTE 1800',''),
	 (8819,652,2,'National','Botswana','BW',28,'Orange','Orange (Botswana) Pty Limited','Operational','GSM 900 / UMTS 2100 / LTE 1800','formerly Vista Cellular'),
	 (8820,652,4,'National','Botswana','BW',28,'BTC Mobile','Botswana Telecommunications Corporation','Operational','GSM 900 / GSM 1800 / LTE 1800',''),
	 (8821,724,0,'National','Brazil','BR',30,'Nextel','NII Holdings, Inc.','Operational','iDEN 850',''),
	 (8822,724,1,'National','Brazil','BR',30,'','SISTEER DO BRASIL TELECOMUNICAÇÔES','Unknown','MVNO','Through Vivo S.A. network'),
	 (8823,724,2,'National','Brazil','BR',30,'TIM','Telecom Italia Mobile','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8824,724,3,'National','Brazil','BR',30,'TIM','Telecom Italia Mobile','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8825,724,4,'National','Brazil','BR',30,'TIM','Telecom Italia Mobile','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8826,724,5,'National','Brazil','BR',30,'Claro','Claro','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8827,724,6,'National','Brazil','BR',30,'Vivo','Vivo S.A.','Operational','GSM 850 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8828,724,10,'National','Brazil','BR',30,'Vivo','Vivo S.A.','Operational','GSM 850 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8829,724,11,'National','Brazil','BR',30,'Vivo','Vivo S.A.','Operational','GSM 850 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8830,724,15,'National','Brazil','BR',30,'Sercomtel','Sercomtel Celular','Operational','GSM 900 / GSM 1800 / UMTS 850',''),
	 (8831,724,16,'National','Brazil','BR',30,'Brasil Telecom GSM','Brasil Telecom GSM','Not operational','GSM 1800 / UMTS 2100','acquired by Oi, MNC used for existing Brasil Telecom SIM Cards only'),
	 (8832,724,17,'National','Brazil','BR',30,'Correios','Correios Celular','Operational','MVNO','Through TIM network'),
	 (8833,724,18,'National','Brazil','BR',30,'datora','Datora (Vodafone)','Operational','MVNO','Through TIM network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8834,724,23,'National','Brazil','BR',30,'Vivo','Vivo S.A.','Operational','GSM 850 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 1800 / LTE 2600','formerly Telemig Celular'),
	 (8835,724,24,'National','Brazil','BR',30,'','Amazonia Celular','Unknown','Unknown','acquired by Oi'),
	 (8836,724,30,'National','Brazil','BR',30,'Oi','TNL PCS Oi','Unknown','Unknown',''),
	 (8837,724,31,'National','Brazil','BR',30,'Oi','TNL PCS Oi','Operational','GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (8838,724,32,'National','Brazil','BR',30,'Algar Telecom','Algar Telecom S.A.','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800','LTE bands 28 / 3'),
	 (8839,724,33,'National','Brazil','BR',30,'Algar Telecom','Algar Telecom S.A.','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800',''),
	 (8840,724,34,'National','Brazil','BR',30,'Algar Telecom','Algar Telecom S.A.','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800',''),
	 (8841,724,35,'National','Brazil','BR',30,'','Telcom Telecomunicações','Unknown','Unknown',''),
	 (8842,724,36,'National','Brazil','BR',30,'','Options Telecomunicações','Unknown','Unknown',''),
	 (8843,724,37,'National','Brazil','BR',30,'aeiou','Unicel','Not operational','Unknown','Bankruptcy in 2011');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8844,724,38,'National','Brazil','BR',30,'Claro','Claro','Unknown','Unknown',''),
	 (8845,724,39,'National','Brazil','BR',30,'Nextel','NII Holdings, Inc.','Operational','UMTS 2100 / LTE 1800',''),
	 (8846,724,54,'National','Brazil','BR',30,'Conecta','PORTO SEGURO TELECOMUNICAÇÔES','Operational','MVNO','Through TIM network'),
	 (8847,724,26,'National','Brazil','BR',30,'AmericaNet Movel','America Net','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (8848,995,1,'National','British Indian Ocean Territory (United Kingdom)','IO',254,'FonePlus','Sure (Diego Garcia) Ltd','Operational','GSM 900','There appears to be no officially assigned MCC'),
	 (8849,348,170,'National','British Virgin Islands (United Kingdom)','VG',233,'FLOW','Cable & Wireless','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 700 / LTE 1900',''),
	 (8850,348,370,'National','British Virgin Islands (United Kingdom)','VG',233,'','BVI Cable TV Ltd','Unknown','Unknown',''),
	 (8851,348,570,'National','British Virgin Islands (United Kingdom)','VG',233,'CCT Boatphone','Caribbean Cellular Telephone','Operational','GSM 900 / GSM 1900 / LTE',''),
	 (8852,348,770,'National','British Virgin Islands (United Kingdom)','VG',233,'Digicel','Digicel (BVI) Limited','Operational','GSM 1800 / GSM 1900 / UMTS / LTE 700',''),
	 (8853,528,1,'National','Brunei','BN',32,'','Jabatan Telekom Brunei','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8854,528,2,'National','Brunei','BN',32,'B-Mobile','B-Mobile Communications Sdn Bhd','Operational','UMTS 2100',''),
	 (8855,528,11,'National','Brunei','BN',32,'DSTCom','Data Stream Technology','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (8856,284,1,'National','Bulgaria','BG',33,'M-Tel','Mobiltel','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100','Former Citron'),
	 (8857,284,3,'National','Bulgaria','BG',33,'Vivacom','BTC','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100','Former Vivatel'),
	 (8858,284,5,'National','Bulgaria','BG',33,'Telenor','Telenor (Bulgaria)','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800','Former Globul'),
	 (8859,284,7,'National','Bulgaria','BG',33,'НКЖИ','НАЦИОНАЛНА КОМПАНИЯ ЖЕЛЕЗОПЪТНА ИНФРАСТРУКТУРА','Operational','GSM-R','(The Bulgarian) National Railway Infrastructure Company'),
	 (8860,284,9,'National','Bulgaria','BG',33,'','COMPATEL LIMITED','Not operational','Unknown','MNC withdrawn'),
	 (8861,284,11,'National','Bulgaria','BG',33,'','Bulsatcom','Operational','LTE 1800',''),
	 (8862,284,13,'National','Bulgaria','BG',33,'MAX','Max Telecom LTD','Operational','LTE 1800',''),
	 (8863,613,1,'National','Burkina Faso','BF',34,'Telmob','Onatel','Operational','GSM 900 / UMTS','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8864,613,2,'National','Burkina Faso','BF',34,'Orange','Orange Burkina Faso','Operational','GSM 900 / UMTS','Previously Zain/Celtel, Airtel'),
	 (8865,613,3,'National','Burkina Faso','BF',34,'Telecel Faso','Telecel Faso SA','Operational','GSM 900',''),
	 (8866,642,1,'National','Burundi','BI',35,'econet Leo','Econet Wireless Burundi PLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE','Former Spacetel'),
	 (8867,642,2,'National','Burundi','BI',35,'Tempo','VTEL MEA','Not operational','GSM 900','Former Safaris. Not related to Africell Suspended in 2015'),
	 (8868,642,3,'National','Burundi','BI',35,'Onatel','Onatel','Operational','GSM 900',''),
	 (8869,642,7,'National','Burundi','BI',35,'Smart Mobile','LACELL SU','Operational','GSM 1800 / UMTS',''),
	 (8870,642,8,'National','Burundi','BI',35,'Lumitel','Viettel Burundi','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE','Formerly HiTs Telecom'),
	 (8871,642,82,'National','Burundi','BI',35,'econet Leo','Econet Wireless Burundi PLC','Operational','GSM 900 / GSM 1800 / UMTS 2100','Formerly Telecel, then U-COM Burundi'),
	 (8872,456,1,'National','Cambodia','KH',36,'Cellcard','CamGSM / The Royal Group','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Mobitel'),
	 (8873,456,2,'National','Cambodia','KH',36,'Smart','Smart Axiata Co. Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8874,456,3,'National','Cambodia','KH',36,'qb','Cambodia Advance Communications Co. Ltd','Operational','GSM 1800 / UMTS 2100','aka CADCOMMS'),
	 (8875,456,4,'National','Cambodia','KH',36,'qb','Cambodia Advance Communications Co. Ltd','Operational','GSM 1800 / UMTS 2100','aka CADCOMMS'),
	 (8876,456,5,'National','Cambodia','KH',36,'Smart','Smart Axiata Co. Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (8877,456,6,'National','Cambodia','KH',36,'Smart','Smart Axiata Co. Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (8878,456,8,'National','Cambodia','KH',36,'Metfone','Viettel','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (8879,456,9,'National','Cambodia','KH',36,'Metfone','Viettel','Operational','GSM 900 / GSM 1800','Former Beeline'),
	 (8880,456,11,'National','Cambodia','KH',36,'SEATEL','SEATEL Cambodia','Operational','LTE 850','Former Excell CDMA shut down 27 June 2015'),
	 (8881,456,18,'National','Cambodia','KH',36,'Cellcard','The Royal Group','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Mfone'),
	 (8882,624,1,'National','Cameroon','CM',37,'MTN Cameroon','Mobile Telephone Network Cameroon Ltd','Operational','GSM 900 / TD-LTE 2500',''),
	 (8883,624,2,'National','Cameroon','CM',37,'Orange','Orange Cameroun S.A.','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8884,624,4,'National','Cameroon','CM',37,'Nexttel','Viettel Cameroun','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8885,302,130,'National','Canada','CA',38,'Xplornet','Xplornet Communications','Operational','TD-LTE 3500 / WiMAX',''),
	 (8886,302,131,'National','Canada','CA',38,'Xplornet','Xplornet Communications','Operational','TD-LTE 3500 / WiMAX',''),
	 (8887,302,220,'National','Canada','CA',38,'Telus Mobility, Koodo Mobile, Public Mobile','Telus Mobility','Operational','UMTS 850 / UMTS 1900 / LTE 1700 / LTE 2600','Used in IMSI to identify Telus subscribers on shared network 302-880'),
	 (8888,302,221,'National','Canada','CA',38,'Telus','Telus Mobility','Unknown','Unknown',''),
	 (8889,302,222,'National','Canada','CA',38,'Telus','Telus Mobility','Unknown','Unknown',''),
	 (8890,302,250,'National','Canada','CA',38,'ALO','ALO Mobile Inc.','Unknown','Unknown',''),
	 (8891,302,270,'National','Canada','CA',38,'EastLink','Bragg Communications','Operational','UMTS 1700 / LTE 1700','Nova Scotia and PEI'),
	 (8892,302,290,'National','Canada','CA',38,'Airtel Wireless','Airtel Wireless','Operational','iDEN 900','Calgary, AB'),
	 (8893,302,300,'National','Canada','CA',38,'','ECOTEL Inc.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8894,302,320,'National','Canada','CA',38,'Rogers Wireless','Rogers Communications','Operational','UMTS 1700','Former Mobilicity'),
	 (8895,302,340,'National','Canada','CA',38,'Execulink','Execulink','Operational','MVNO',''),
	 (8896,302,350,'National','Canada','CA',38,'FIRST','FIRST Networks Operations','Not operational','GSM 850','MNC withdrawn'),
	 (8897,302,360,'National','Canada','CA',38,'MiKe','Telus Mobility','Not operational','iDEN 800','iDEN shut down January 2016'),
	 (8898,302,361,'National','Canada','CA',38,'Telus','Telus Mobility','Not operational','CDMA 800 / CDMA 1900','CDMA shut down 31 May 2017; MNC withdrawn'),
	 (8899,302,370,'National','Canada','CA',38,'Fido','Fido Solutions (Rogers Wireless)','Operational','MVNO','former Microcell Telecommunications'),
	 (8900,302,380,'National','Canada','CA',38,'Keewaytinook Mobile','Keewaytinook Okimakanak Mobile','Operational','UMTS 850 / UMTS 1900','Former Dryden Mobility'),
	 (8901,302,390,'National','Canada','CA',38,'DMTS','Dryden Mobility','Not operational','Unknown','Acquired by Tbaytel in 2012; MNC withdrawn'),
	 (8902,302,420,'National','Canada','CA',38,'ABC','A.B.C. Allen Business Communications Ltd.','Operational','TD-LTE 3500','British Columbia'),
	 (8903,302,480,'National','Canada','CA',38,'SSi Connexions','SSi Connexions','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8904,302,490,'National','Canada','CA',38,'Freedom Mobile','Shaw Communications','Operational','UMTS 1700 / LTE 1700','Former Wind Mobile; LTE bands 4, 66'),
	 (8905,302,491,'National','Canada','CA',38,'Freedom Mobile','Shaw Communications','Unknown','Unknown',''),
	 (8906,302,500,'National','Canada','CA',38,'Videotron','Videotron','Operational','UMTS 1700 / LTE 1700',''),
	 (8907,302,510,'National','Canada','CA',38,'Videotron','Videotron','Operational','UMTS 1700 / LTE 1700',''),
	 (8908,302,520,'National','Canada','CA',38,'Videotron','Videotron','Unknown','Unknown',''),
	 (8909,302,530,'National','Canada','CA',38,'Keewaytinook Mobile','Keewaytinook Okimakanak Mobile','Operational','GSM','Northwestern Ontario; also spelled Keewatinook Okimacinac'),
	 (8910,302,540,'National','Canada','CA',38,'','Rovvr Communications Inc.','Unknown','Unknown',''),
	 (8911,302,560,'National','Canada','CA',38,'Lynx Mobility','Lynx Mobility','Operational','CDMA / GSM','Northern Quebec, Nunavut, Labrador'),
	 (8912,302,570,'National','Canada','CA',38,'LightSquared','LightSquared','Unknown','Unknown',''),
	 (8913,302,590,'National','Canada','CA',38,'Quadro Mobility','Quadro Communications Co-op','Operational','Unknown','Southwestern Ontario');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8914,302,610,'National','Canada','CA',38,'Bell Mobility, Virgin Mobile Canada','Bell Mobility','Operational','UMTS 850 / UMTS 1900 / LTE 700 / LTE 1700 / LTE 1900 / LTE 2600','Used in IMSI to identify Bell subscribers on shared network 302-880; LTE bands 17, 29, 4, 2, 7'),
	 (8915,302,620,'National','Canada','CA',38,'ICE Wireless','ICE Wireless','Operational','UMTS 850 / GSM 1900','Northern Canada'),
	 (8916,302,630,'National','Canada','CA',38,'Aliant Mobility','Bell Aliant','Unknown','Unknown',''),
	 (8917,302,640,'National','Canada','CA',38,'Bell','Bell Mobility','Operational','CDMA 800 / CDMA 1900','CDMA shutting down in April 2018'),
	 (8918,302,650,'National','Canada','CA',38,'TBaytel','Thunder Bay Telephone','Operational','UMTS 850 / UMTS 1900 / LTE 2600',''),
	 (8919,302,652,'National','Canada','CA',38,'','BC Tel Mobility (Telus)','Not operational','CDMA2000','CDMA shut down 31 May 2017'),
	 (8920,302,653,'National','Canada','CA',38,'Telus','Telus Mobility','Not operational','CDMA 800 / CDMA 1900','CDMA shut down 31 May 2017'),
	 (8921,302,655,'National','Canada','CA',38,'MTS','MTS Mobility','Operational','CDMA 800 / CDMA 1900','former Manitoba Telephone System'),
	 (8922,302,656,'National','Canada','CA',38,'TBay','Thunder Bay Telephone Mobility','Not operational','CDMA','MNC withdrawn; CDMA shut down 1 October 2014'),
	 (8923,302,657,'National','Canada','CA',38,'Telus','Telus Mobility','Not operational','CDMA 800 / CDMA 1900','CDMA shut down 31 May 2017');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8924,302,660,'National','Canada','CA',38,'MTS','Bell MTS','Operational','UMTS 850 / UMTS 1900 / LTE 1700',''),
	 (8925,302,670,'National','Canada','CA',38,'CityTel Mobility','CityWest','Unknown','Unknown',''),
	 (8926,302,680,'National','Canada','CA',38,'SaskTel','SaskTel Mobility','Operational','TD-LTE 2600','CDMA 850 shut down 5 July 2017'),
	 (8927,302,690,'National','Canada','CA',38,'Bell','Bell Mobility','Operational','UMTS 850 / UMTS 1900',''),
	 (8928,302,701,'National','Canada','CA',38,'','MB Tel Mobility','Operational','CDMA2000',''),
	 (8929,302,702,'National','Canada','CA',38,'','MT&T Mobility (Aliant)','Operational','CDMA2000',''),
	 (8930,302,703,'National','Canada','CA',38,'','New Tel Mobility (Aliant)','Operational','CDMA2000',''),
	 (8931,302,710,'National','Canada','CA',38,'Globalstar','','Operational','Satellite CDMA',''),
	 (8932,302,720,'National','Canada','CA',38,'Rogers Wireless','Rogers Communications','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 700 / LTE 1700 / LTE 2600','former Rogers AT&T Wireless; LTE bands 12, 4, 7'),
	 (8933,302,730,'National','Canada','CA',38,'TerreStar Solutions','TerreStar Networks','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8934,302,740,'National','Canada','CA',38,'Shaw Telecom','Shaw Communications','Not operational','Unknown',''),
	 (8935,302,750,'National','Canada','CA',38,'SaskTel','SaskTel Mobility','Unknown','Unknown',''),
	 (8936,302,760,'National','Canada','CA',38,'Public Mobile','Telus Mobility','Operational','MVNO','Acquired by Telus, CDMA network shut down 2014'),
	 (8937,302,770,'National','Canada','CA',38,'TNW Wireless','TNW Wireless Inc.','Operational','UMTS 850','Former Rural Com; national coverage based on iPCS technology and Wi-Nodes'),
	 (8938,302,780,'National','Canada','CA',38,'SaskTel','SaskTel Mobility','Operational','UMTS 850 / UMTS 1900 / LTE 1700',''),
	 (8939,302,790,'National','Canada','CA',38,'','NetSet Communications','Operational','WiMAX / TD-LTE 3500','Manitoba'),
	 (8940,302,820,'National','Canada','CA',38,'Rogers Wireless','Rogers Communications','Unknown','Unknown',''),
	 (8941,302,860,'National','Canada','CA',38,'Telus','Telus Mobility','Unknown','Unknown',''),
	 (8942,302,880,'National','Canada','CA',38,'Bell / Telus / SaskTel','Shared Telus, Bell, and SaskTel','Operational','UMTS 850 / UMTS 1900',''),
	 (8943,302,920,'National','Canada','CA',38,'Rogers Wireless','Rogers Communications','Not operational','Unknown','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8944,302,940,'National','Canada','CA',38,'Wightman Mobility','Wightman Telecom','Operational','UMTS 850 / UMTS 1900',''),
	 (8945,302,990,'National','Canada','CA',38,'','','Unknown','Unknown','For testing'),
	 (8946,625,1,'National','Cape Verde','CV',39,'CVMOVEL','CVMóvel, S.A.','Operational','GSM 900 / UMTS',''),
	 (8947,625,2,'National','Cape Verde','CV',39,'T+','UNITEL T+ TELECOMUNICACÕES, S.A.','Operational','GSM 1800 / UMTS 2100',''),
	 (8948,346,140,'National','Cayman Islands (United Kingdom)','KY',40,'FLOW','Cable & Wireless (Cayman Islands) Limited','Operational','GSM 850 / GSM 1900 / UMTS / LTE 700 / LTE 1900','LTE bands 17 / 2'),
	 (8949,346,50,'National','Cayman Islands (United Kingdom)','KY',40,'Digicel','Digicel Cayman Ltd.','Operational','GSM 900 / GSM 1800 / UMTS / LTE 1800',''),
	 (8950,623,1,'National','Central African Republic','CF',41,'CTP','Centrafrique Telecom Plus','Operational','GSM 900','now Atlantique Telecom Centrafrique SA (ETISALAT)'),
	 (8951,623,2,'National','Central African Republic','CF',41,'TC','Telecel Centrafrique','Operational','GSM 900',''),
	 (8952,623,3,'National','Central African Republic','CF',41,'Orange','Orange RCA','Operational','GSM 1800 / UMTS',''),
	 (8953,623,4,'National','Central African Republic','CF',41,'Nationlink','Nationlink Telecom RCA','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8954,622,1,'National','Chad','TD',42,'Airtel','Bharti Airtel SA','Operational','GSM 900 / UMTS',''),
	 (8955,622,2,'National','Chad','TD',42,'Tawali','SotelTchad','Operational','CDMA2000','semi-fixed line; formerly Tchad Mobile / Orascom Telecom GSM 900 - defunct in 2004'),
	 (8956,622,3,'National','Chad','TD',42,'Tigo','Millicom','Operational','GSM 900 / GSM 1800 / UMTS / LTE 2600',''),
	 (8957,622,7,'National','Chad','TD',42,'Salam','SotelTchad','Operational','GSM 900 / GSM 1800',''),
	 (8958,730,1,'National','Chile','CL',43,'entel','Entel Telefonía Móvil S.A.','Operational','GSM 1900 / UMTS 1900 / LTE 700 / LTE 2600',''),
	 (8959,730,2,'National','Chile','CL',43,'movistar','Telefónica Móvil de Chile','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 700 / LTE 2600',''),
	 (8960,730,3,'National','Chile','CL',43,'CLARO CL','Claro Chile S.A.','Operational','GSM 1900 / UMTS 850 / UMTS 1900 / LTE 2600',''),
	 (8961,730,4,'National','Chile','CL',43,'WOM','Novator Partners','Operational','iDEN 800','Former Nextel'),
	 (8962,730,5,'National','Chile','CL',43,'','Multikom S.A.','Unknown','Unknown',''),
	 (8963,730,6,'National','Chile','CL',43,'Telsur','Blue Two Chile S.A.','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8964,730,7,'National','Chile','CL',43,'movistar','Telefónica Móvil de Chile','Unknown','Unknown',''),
	 (8965,730,8,'National','Chile','CL',43,'VTR Móvil','VTR S.A.','Operational','MVNO','Uses movistar'),
	 (8966,730,9,'National','Chile','CL',43,'WOM','Novator Partners','Operational','UMTS 1700 / LTE 1700','Former Nextel; roaming with entel and Claro networks (GSM / UMTS)'),
	 (8967,730,10,'National','Chile','CL',43,'entel','Entel Telefonía Móvil S.A.','Operational','GSM 1900 / UMTS 1900',''),
	 (8968,730,11,'National','Chile','CL',43,'','Celupago S.A.','Unknown','Unknown',''),
	 (8969,730,12,'National','Chile','CL',43,'Colo-Colo Móvil
Wanderers Móvil','Telestar Móvil S.A.','Operational','MVNO','Uses movistar'),
	 (8970,730,13,'National','Chile','CL',43,'Virgin Mobile','Tribe Mobile Chile SPA','Operational','MVNO','Uses movistar'),
	 (8971,730,14,'National','Chile','CL',43,'','Netline Telefónica Móvil Ltda','Unknown','Unknown',''),
	 (8972,730,15,'National','Chile','CL',43,'','Cibeles Telecom S.A.','Unknown','Unknown',''),
	 (8973,730,16,'National','Chile','CL',43,'','Nomade Telecomunicaciones S.A.','Unknown','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8974,730,17,'National','Chile','CL',43,'','COMPATEL Chile Limitada','Unknown','Unknown',''),
	 (8975,730,18,'National','Chile','CL',43,'','Empresas Bunker S.A.','Unknown','Unknown',''),
	 (8976,730,19,'National','Chile','CL',43,'móvil Falabella','Sociedad Falabella Móvil SPA','Operational','MVNO','Uses entel'),
	 (8977,730,20,'National','Chile','CL',43,'','Inversiones Santa Fe Limitada','Unknown','Unknown',''),
	 (8978,730,22,'National','Chile','CL',43,'','Cellplus SpA','Unknown','Unknown',''),
	 (8979,730,23,'National','Chile','CL',43,'','Claro Servicios Empresariales S. A.','Unknown','Unknown',''),
	 (8980,730,99,'National','Chile','CL',43,'Will','WILL Telefonía','Operational','GSM 1900 / UMTS 1900','Wireless local loop'),
	 (8981,460,0,'National','China','CN',44,'China Mobile','China Mobile','Operational','GSM 900 / GSM 1800 / TD-SCDMA 1900 / TD-SCDMA 2000 / TD-LTE 1900 / TD-LTE 2300 / TD-LTE 2500',''),
	 (8982,460,1,'National','China','CN',44,'China Unicom','China Unicom','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / TD-LTE 2300 / TD-LTE 2500','CDMA network sold to China Telecom'),
	 (8983,460,2,'National','China','CN',44,'China Mobile','China Mobile','Not operational','GSM 900 / GSM 1800 / TD-SCDMA 1900 / TD-SCDMA 2000 / TD-LTE 1900 / TD-LTE 2300 / TD-LTE 2500','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8984,460,3,'National','China','CN',44,'China Telecom','China Telecom','Operational','CDMA2000 800 / LTE 850 / LTE 1800 / LTE 2100 / TD-LTE 2300 / TD-LTE 2500','EV-DO'),
	 (8985,460,4,'National','China','CN',44,'','Global Star Satellite','Unknown','Unknown',''),
	 (8986,460,5,'National','China','CN',44,'China Telecom','China Telecom','Not operational','CDMA2000 800 / LTE 850 / LTE 1800 / LTE 2100 / TD-LTE 2300 / TD-LTE 2500',''),
	 (8987,460,6,'National','China','CN',44,'China Unicom','China Unicom','Not operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (8988,460,7,'National','China','CN',44,'China Mobile','China Mobile','Not operational','GSM 900 / GSM 1800 / TD-SCDMA 1900 / TD-SCDMA 2000 / TD-LTE 1900 / TD-LTE 2300 / TD-LTE 2500',''),
	 (8989,460,8,'National','China','CN',44,'China Mobile','China Mobile','Unknown','Unknown',''),
	 (8990,460,9,'National','China','CN',44,'China Unicom','China Unicom','Unknown','Unknown',''),
	 (8991,460,11,'National','China','CN',44,'China Telecom','China Telecom','Unknown','Unknown',''),
	 (8992,460,20,'National','China','CN',44,'China Tietong','China Tietong','Operational','GSM-R',''),
	 (8993,0,0,'National','Christmas Island (Australia)','CX',45,'','','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (8994,0,0,'National','Cocos Islands (Australia)','CC',46,'','','','',''),
	 (8995,732,1,'National','Colombia','CO',47,'movistar','Colombia Telecomunicaciones S.A. ESP','Operational','Unknown',''),
	 (8996,732,2,'National','Colombia','CO',47,'Edatel','Edatel S.A. ESP','Unknown','Unknown',''),
	 (8997,732,3,'National','Colombia','CO',47,'','LLEIDA S.A.S.','Unknown','Unknown',''),
	 (8998,732,4,'National','Colombia','CO',47,'','COMPATEL COLOMBIA SAS','Unknown','Unknown',''),
	 (8999,732,20,'National','Colombia','CO',47,'Tigo','Une EPM Telecomunicaciones S.A. E.S.P.','Operational','LTE 2600','Former Une-EPM; Former Emtelsa; merged with Tigo'),
	 (9000,732,99,'National','Colombia','CO',47,'EMCALI','Empresas Municipales de Cali','Operational','GSM 900',''),
	 (9001,732,101,'National','Colombia','CO',47,'Claro','COMCEL S.A.','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 2600',''),
	 (9002,732,102,'National','Colombia','CO',47,'','Bellsouth Colombia','Not operational','GSM 850 / GSM 1900 / CDMA 850','MNC withdrawn; network acquired by movistar'),
	 (9003,732,103,'National','Colombia','CO',47,'Tigo','Colombia Móvil S.A. ESP','Operational','GSM 1900 / UMTS / LTE 1700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9004,732,111,'National','Colombia','CO',47,'Tigo','Colombia Móvil S.A. ESP','Operational','GSM 1900 / UMTS / LTE 1700',''),
	 (9005,732,123,'National','Colombia','CO',47,'movistar','Colombia Telecomunicaciones S.A. ESP','Operational','GSM 850 / GSM 1900 / UMTS / LTE 1700 / LTE 1900 / CDMA 850',''),
	 (9006,732,130,'National','Colombia','CO',47,'AVANTEL','Avantel S.A.S','Operational','GSM 850 / iDEN / LTE 1700',''),
	 (9007,732,142,'National','Colombia','CO',47,'','Une EPM Telecomunicaciones S.A. E.S.P.','Unknown','Unknown',''),
	 (9008,732,154,'National','Colombia','CO',47,'Virgin Mobile','Virgin Mobile Colombia S.A.S.','Operational','MVNO','Uses movistar'),
	 (9009,732,165,'National','Colombia','CO',47,'','Colombia Móvil S.A. ESP','Unknown','Unknown',''),
	 (9010,732,176,'National','Colombia','CO',47,'','DirecTV Colombia Ltda','Operational','TD-LTE 2600',''),
	 (9011,732,187,'National','Colombia','CO',47,'eTb','Empresa de Telecomunicaciones de Bogotá S.A. ESP','Operational','LTE 1700',''),
	 (9012,732,199,'National','Colombia','CO',47,'','SUMA Movil SAS','Unknown','Unknown',''),
	 (9013,732,208,'National','Colombia','CO',47,'','UFF Movil SAS','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9014,654,1,'National','Comoros','KM',48,'HURI','Comoros Telecom','Operational','GSM 900',''),
	 (9015,654,2,'National','Comoros','KM',48,'TELCO SA','Telecom Malagasy (Telma)','Operational','GSM 900 / UMTS 900 / LTE 800',''),
	 (9016,629,1,'National','Congo','CG',49,'Airtel','Celtel Congo','Operational','GSM 900 / UMTS 2100','Former Zain and Celtel brand'),
	 (9017,629,7,'National','Congo','CG',49,'Warid','Warid Telecom','Operational','GSM 900',''),
	 (9018,629,10,'National','Congo','CG',49,'Libertis Telecom','MTN CONGO S.A','Operational','GSM 900',''),
	 (9019,548,1,'National','Cook Islands (Pacific Ocean)','CK',51,'Bluesky','Telecom Cook Islands','Operational','GSM 900 / UMTS 900 / LTE',''),
	 (9020,712,1,'National','Costa Rica','CR',52,'Kolbi ICE','Instituto Costarricense de Electricidad','Operational','GSM 1800 / UMTS 850 / LTE 2600',''),
	 (9021,712,2,'National','Costa Rica','CR',52,'Kolbi ICE','Instituto Costarricense de Electricidad','Operational','GSM 1800 / UMTS 850 / LTE 2600',''),
	 (9022,712,3,'National','Costa Rica','CR',52,'Claro','Claro CR Telecomunicaciones (Aló)','Operational','GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9023,712,4,'National','Costa Rica','CR',52,'movistar','Telefónica Móviles Costa Rica','Operational','GSM 1800 / UMTS 850 / UMTS 2100 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9024,712,20,'National','Costa Rica','CR',52,'fullmóvil','Virtualis S.A.','Operational','GSM 1800 / UMTS 850',''),
	 (9025,219,1,'National','Croatia','HR',54,'T-Mobile','T-Hrvatski Telekom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9026,219,2,'National','Croatia','HR',54,'Tele2','Tele2','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (9027,219,10,'National','Croatia','HR',54,'Vip','Vipnet','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9028,219,12,'National','Croatia','HR',54,'','TELE FOCUS d.o.o.','Unknown','MVNO',''),
	 (9029,368,1,'National','Cuba','CU',55,'CUBACEL','Empresa de Telecomunicaciones de Cuba, SA','Operational','GSM 900 / GSM 850 / UMTS 900','GSM 850 only available in limited areas (Havana, Varadero, Trinidad and Cayo Coco)'),
	 (9030,280,1,'National','Cyprus','CY',56,'Cytamobile-Vodafone','Cyprus Telecommunications Authority','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9031,280,10,'National','Cyprus','CY',56,'MTN','MTN Group','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9032,280,20,'National','Cyprus','CY',56,'PrimeTel','PrimeTel PLC','Operational','LTE 1800','Originally MVNO, MNO since 2015. Uses MTN for 2G/3G roaming.'),
	 (9033,280,22,'National','Cyprus','CY',56,'lemontel','Lemontel Ltd','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9034,280,23,'National','Cyprus','CY',56,'Vectone Mobile','Mundio Mobile Cyprus Ltd.','Unknown','MVNO',''),
	 (9035,230,1,'National','Czech Republic','CZ',57,'T-Mobile','T-Mobile Czech Republic','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','former Paegas'),
	 (9036,230,2,'National','Czech Republic','CZ',57,'O2','O2 Czech Republic','Operational','CDMA 450 / GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','former Eurotel'),
	 (9037,230,3,'National','Czech Republic','CZ',57,'Vodafone','Vodafone Czech Republic','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2100','former Oskar'),
	 (9038,230,4,'National','Czech Republic','CZ',57,'','Nordic Telecom s.r.o.','Operational','MVNO','former U:fon, Air Telecom; CDMA 420MHz shut down Dec 2017'),
	 (9039,230,5,'National','Czech Republic','CZ',57,'','PODA a.s.','Unknown','TD-LTE 3700','Former TRAVEL TELEKOMMUNIKATION'),
	 (9040,230,6,'National','Czech Republic','CZ',57,'','OSNO TELECOMUNICATION, s.r.o.','Not operational','Unknown','MNC withdrawn'),
	 (9041,230,7,'National','Czech Republic','CZ',57,'','ASTELNET, s.r.o.','Not operational','MVNO','MNC withdrawn'),
	 (9042,230,8,'National','Czech Republic','CZ',57,'','Compatel s.r.o.','Unknown','Unknown',''),
	 (9043,230,9,'National','Czech Republic','CZ',57,'Vectone Mobile','Mundio Distribution Czech Republic s.r.o.','Unknown','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9044,230,98,'National','Czech Republic','CZ',57,'','Správa železniční dopravní cesty, s.o.','Operational','GSM-R 900','railways communication'),
	 (9045,230,99,'National','Czech Republic','CZ',57,'Vodafone','Vodafone Czech Republic','Operational','GSM 1800','R&D Centre at FEE, CTU (educational, experimental)'),
	 (9046,630,1,'National','Democratic Republic of the Congo','CD',50,'Vodacom','Vodacom Congo RDC sprl','Operational','GSM 900 / GSM 1800 / UMTS / LTE',''),
	 (9047,630,2,'National','Democratic Republic of the Congo','CD',50,'Airtel','Airtel sprl','Operational','GSM 900 / UMTS',''),
	 (9048,630,4,'National','Democratic Republic of the Congo','CD',50,'','Cellco','Unknown','Unknown',''),
	 (9049,630,5,'National','Democratic Republic of the Congo','CD',50,'Supercell','Supercell SPRL','Operational','GSM 900 / GSM 1800',''),
	 (9050,630,10,'National','Democratic Republic of the Congo','CD',50,'MTN','','Operational','GSM / LTE','Former Libertis Telecom'),
	 (9051,630,86,'National','Democratic Republic of the Congo','CD',50,'Orange S.A.','Orange RDC sarl','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9052,630,88,'National','Democratic Republic of the Congo','CD',50,'YTT','Yozma Timeturns sprl','Not operational','GSM 900 / GSM 1800','Planned'),
	 (9053,630,89,'National','Democratic Republic of the Congo','CD',50,'Tigo','OASIS sprl','Operational','GSM 900 / GSM 1800 / UMTS 2100','a Millicom Company');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9054,630,90,'National','Democratic Republic of the Congo','CD',50,'Africell','Africell RDC sprl','Operational','GSM 900 / GSM 1800',''),
	 (9055,238,1,'National','Denmark (Kingdom of Denmark)','DK',58,'TDC','TDC A/S','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9056,238,2,'National','Denmark (Kingdom of Denmark)','DK',58,'Telenor','Telenor Denmark','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Sonofon'),
	 (9057,238,3,'National','Denmark (Kingdom of Denmark)','DK',58,'','Syniverse Technologies','Unknown','Unknown','Former End2End / MIGway A/S / MACH Connectivity'),
	 (9058,238,4,'National','Denmark (Kingdom of Denmark)','DK',58,'','NextGen Mobile Ltd T/A CardBoardFish','Unknown','Unknown',''),
	 (9059,238,5,'National','Denmark (Kingdom of Denmark)','DK',58,'TetraNet','Dansk Beredskabskommunikation A/S','Operational','TETRA','Former ApS KBUS 38 nr. 4418; owned by Motorola Solutions'),
	 (9060,238,6,'National','Denmark (Kingdom of Denmark)','DK',58,'3','Hi3G Denmark ApS','Operational','UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (9061,238,7,'National','Denmark (Kingdom of Denmark)','DK',58,'Vectone Mobile','Mundio Mobile (Denmark) Limited','Operational','MVNO','Former Barablu MNO: Denmark Telenor'),
	 (9062,238,8,'National','Denmark (Kingdom of Denmark)','DK',58,'Voxbone','Voxbone mobile','Operational','MVNO','Former Nordisk Mobiltelefon'),
	 (9063,238,9,'National','Denmark (Kingdom of Denmark)','DK',58,'SINE','Dansk Beredskabskommunikation A/S','Operational','TETRA','Owned by Motorola Solutions');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9064,238,10,'National','Denmark (Kingdom of Denmark)','DK',58,'TDC','TDC A/S','Operational','Unknown','Test network'),
	 (9065,238,11,'National','Denmark (Kingdom of Denmark)','DK',58,'SINE','Dansk Beredskabskommunikation A/S','Operational','TETRA','Test network'),
	 (9066,238,12,'National','Denmark (Kingdom of Denmark)','DK',58,'Lycamobile','Lycamobile Denmark Ltd','Operational','MVNO',''),
	 (9067,238,13,'National','Denmark (Kingdom of Denmark)','DK',58,'','Compatel Limited','Unknown','Unknown',''),
	 (9068,238,14,'National','Denmark (Kingdom of Denmark)','DK',58,'','Monty UK Global Limited','Unknown','Unknown',''),
	 (9069,238,15,'National','Denmark (Kingdom of Denmark)','DK',58,'','Ice Danmark ApS','Unknown','Unknown',''),
	 (9070,238,16,'National','Denmark (Kingdom of Denmark)','DK',58,'','Tismi B.V.','Unknown','Unknown',''),
	 (9071,238,17,'National','Denmark (Kingdom of Denmark)','DK',58,'','Naka AG','Not operational','MVNO','MNC withdrawn'),
	 (9072,238,18,'National','Denmark (Kingdom of Denmark)','DK',58,'','Cubic Telecom','Unknown','Unknown',''),
	 (9073,238,20,'National','Denmark (Kingdom of Denmark)','DK',58,'Telia','Telia','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9074,238,23,'National','Denmark (Kingdom of Denmark)','DK',58,'GSM-R DK','Banedanmark','Operational','GSM-R',''),
	 (9075,238,25,'National','Denmark (Kingdom of Denmark)','DK',58,'Viahub','SMS Provider Corp.','Unknown','MVNO',''),
	 (9076,238,28,'National','Denmark (Kingdom of Denmark)','DK',58,'','LINK Mobile A/S','Unknown','Unknown','Former CoolTEL ApS'),
	 (9077,238,30,'National','Denmark (Kingdom of Denmark)','DK',58,'','Interactive digital media GmbH','Unknown','Unknown','Former Telia'),
	 (9078,238,40,'National','Denmark (Kingdom of Denmark)','DK',58,'','Ericsson Danmark A/S','Not operational','Unknown','Test network; former Sense Communications Denmark A/S; MNC withdrawn'),
	 (9079,238,42,'National','Denmark (Kingdom of Denmark)','DK',58,'','Greenwave Mobile IoT ApS','Unknown','Unknown','Former Brandtel ApS, Tel42 ApS'),
	 (9080,238,43,'National','Denmark (Kingdom of Denmark)','DK',58,'','MobiWeb Limited','Not operational','Unknown','MNC withdrawn'),
	 (9081,238,66,'National','Denmark (Kingdom of Denmark)','DK',58,'','TT-Netværket P/S','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Telia, now shared network Telia/Telenor'),
	 (9082,238,73,'National','Denmark (Kingdom of Denmark)','DK',58,'','Onomondo ApS','Unknown','Unknown',''),
	 (9083,238,77,'National','Denmark (Kingdom of Denmark)','DK',58,'Telenor','Telenor Denmark','Operational','GSM 900 / GSM 1800','Former Tele2');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9084,638,1,'National','Djibouti','DJ',59,'Evatis','Djibouti Telecom SA','Operational','GSM 900 / UMTS',''),
	 (9085,366,20,'National','Dominica','DM',60,'Digicel','Digicel Group Limited','Operational','GSM 900 / GSM 1900 / UMTS 900 / UMTS 1800 / UMTS 1900 / LTE','Former Orange Dominica'),
	 (9086,366,110,'National','Dominica','DM',60,'FLOW','Cable & Wireless','Operational','GSM 850 / UMTS / LTE 700',''),
	 (9087,370,1,'National','Dominican Republic','DO',61,'Altice','Altice Group','Operational','GSM 900 / GSM 1800 / GSM 1900 / UMTS 900 / LTE 1800','Former Orange Dominicana'),
	 (9088,370,2,'National','Dominican Republic','DO',61,'Claro','Compañía Dominicana de Teléfonos','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 1700','CDMA 1900 shut down in 2014'),
	 (9089,370,3,'National','Dominican Republic','DO',61,'Altice','Altice Group','Operational','AMPS / CDMA 850','Former Tricom, S.A, 1900MHz spectrum returned to regulator'),
	 (9090,370,4,'National','Dominican Republic','DO',61,'Viva','Trilogy Dominicana, S.A.','Operational','CDMA 1900 / GSM 1900','Former Centennial Dominicana'),
	 (9091,370,5,'National','Dominican Republic','DO',61,'Wind','WIND Telecom, S.A','Operational','TD-LTE 2600','LTE band 38'),
	 (9092,514,1,'National','East Timor','TL',212,'Telkomcel','PT Telekomunikasi Indonesia International','Operational','GSM 900 / GSM 1800 / UMTS 850 / LTE',''),
	 (9093,514,2,'National','East Timor','TL',212,'TT','Timor Telecom','Operational','GSM 900 / UMTS / LTE','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9094,514,3,'National','East Timor','TL',212,'Telemor','Viettel Timor-Leste','Operational','GSM 900 / GSM 1800 / UMTS / LTE',''),
	 (9095,740,0,'National','Ecuador','EC',62,'Movistar','Otecel S.A.','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 1900','Former BellSouth'),
	 (9096,740,1,'National','Ecuador','EC',62,'Claro','CONECEL S.A.','Operational','GSM 850 / UMTS 850 / UMTS 1900 / LTE 1700','Former Porta'),
	 (9097,740,2,'National','Ecuador','EC',62,'CNT Mobile','Corporación Nacional de Telecomunicaciones (CNT EP)','Operational','GSM 850 / UMTS 1900 / LTE 1700','Former Alegro / Telecsa; CDMA 1900 shut down in 2014'),
	 (9098,740,3,'National','Ecuador','EC',62,'Tuenti','Otecel S.A.','Operational','MVNO','Runs on Movistar''s Network'),
	 (9099,602,1,'National','Egypt','EG',63,'Orange','Orange Egypt','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Mobinil'),
	 (9100,602,2,'National','Egypt','EG',63,'Vodafone','Vodafone Egypt','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9101,602,3,'National','Egypt','EG',63,'Etisalat','Etisalat Egypt','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9102,602,4,'National','Egypt','EG',63,'WE','Telecom Egypt','Operational','LTE',''),
	 (9103,706,1,'National','El Salvador','SV',64,'Claro','CTE Telecom Personal, S.A. de C.V.','Operational','GSM 1900 / UMTS 1900','owned by América Móvil');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9104,706,2,'National','El Salvador','SV',64,'digicel','Digicel, S.A. de C.V.','Operational','GSM 900 / UMTS 900',''),
	 (9105,706,3,'National','El Salvador','SV',64,'Tigo','Telemovil El Salvador S.A.','Operational','GSM 850 / UMTS 850 / LTE 850',''),
	 (9106,706,4,'National','El Salvador','SV',64,'movistar','Telefónica Móviles El Salvador','Operational','GSM 850 / GSM 1900 / UMTS 1900 / LTE 1900',''),
	 (9107,706,5,'National','El Salvador','SV',64,'RED','INTELFON, S.A. de C.V.','Operational','iDEN',''),
	 (9108,627,1,'National','Equatorial Guinea','GQ',65,'Orange GQ','GETESA','Operational','GSM 900',''),
	 (9109,627,3,'National','Equatorial Guinea','GQ',65,'Hits GQ','HiTs EG.SA','Operational','GSM 900 / GSM 1800',''),
	 (9110,657,1,'National','Eritrea','ER',66,'Eritel','Eritrea Telecommunications Services Corporation','Operational','GSM 900',''),
	 (9111,248,1,'National','Estonia','EE',67,'Telia','Estonian Mobile Telecom','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former EMT'),
	 (9112,248,2,'National','Estonia','EE',67,'Elisa','Elisa Eesti','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9113,248,3,'National','Estonia','EE',67,'Tele2','Tele2 Eesti','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9114,248,4,'National','Estonia','EE',67,'Top Connect','OY Top Connect','Operational','MVNO',''),
	 (9115,248,5,'National','Estonia','EE',67,'','AS Bravocom Mobiil','Not operational','Unknown','MNC withdrawn'),
	 (9116,248,6,'National','Estonia','EE',67,'','Progroup Holding','Not operational','UMTS 2100','MNC withdrawn'),
	 (9117,248,7,'National','Estonia','EE',67,'Kou','Televõrgu AS','Not operational','CDMA2000 450','Acquired by Tele 2 in 2012; shut down in January 2016'),
	 (9118,248,8,'National','Estonia','EE',67,'VIVEX','VIVEX OU','Not operational','MVNO','MNC withdrawn'),
	 (9119,248,9,'National','Estonia','EE',67,'','Bravo Telecom','Not operational','Unknown','MNC withdrawn'),
	 (9120,248,10,'National','Estonia','EE',67,'','Telcotrade OÜ','Not operational','Unknown','MNC withdrawn'),
	 (9121,248,11,'National','Estonia','EE',67,'','UAB Raystorm Eesti filiaal','Unknown','Unknown',''),
	 (9122,248,71,'National','Estonia','EE',67,'','Siseministeerium (Ministry of Interior)','Unknown','Unknown',''),
	 (9123,636,1,'National','Ethiopia','ET',68,'MTN','Ethio Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9124,750,1,'National','Falkland Islands (United Kingdom)','FK',69,'Sure','Sure South Atlantic Ltd.','Operational','GSM 900','formerly Cable & Wireless Communications Touch'),
	 (9125,288,1,'National','Faroe Islands (Kingdom of Denmark)','FO',70,'Faroese Telecom','Faroese Telecom','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9126,288,2,'National','Faroe Islands (Kingdom of Denmark)','FO',70,'Hey','Vodafone Faroe Islands','Operational','GSM 900 / UMTS 2100 / LTE 1800','Former Kall, also uses MCC 274 MNC 02 (Iceland)'),
	 (9127,288,3,'National','Faroe Islands (Kingdom of Denmark)','FO',70,'','Edge Mobile Sp/F','Not operational','GSM 1800','Planned'),
	 (9128,542,1,'National','Fiji','FJ',71,'Vodafone','Vodafone Fiji','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (9129,542,2,'National','Fiji','FJ',71,'Digicel','Digicel Fiji','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / WiMAX',''),
	 (9130,542,3,'National','Fiji','FJ',71,'','Telecom Fiji Ltd','Operational','CDMA2000 850 / LTE 700','LTE band 28'),
	 (9131,244,3,'National','Finland','FI',72,'DNA','DNA Oy','Operational','GSM 1800','Former Telia'),
	 (9132,244,4,'National','Finland','FI',72,'DNA','DNA Oy','Unknown','Unknown','Former Aina Oyj'),
	 (9133,244,5,'National','Finland','FI',72,'Elisa','Elisa Oyj','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Radiolinja');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9134,244,6,'National','Finland','FI',72,'Elisa','Elisa Oyj','Not operational','Unknown','MNC withdrawn'),
	 (9135,244,7,'National','Finland','FI',72,'Nokia','Nokia Solutions and Networks Oy','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600 / TD-LTE 2600','Test network in Espoo Leppävaara and Nokia HQ'),
	 (9136,244,8,'National','Finland','FI',72,'Nokia','Nokia Solutions and Networks Oy','Unknown','GSM 1800 / UMTS 2100',''),
	 (9137,244,9,'National','Finland','FI',72,'','Nokia Solutions and Networks Oy','Unknown','GSM 900','Former Finnet Group'),
	 (9138,244,10,'National','Finland','FI',72,'','Viestintävirasto','Unknown','Unknown','Former TDC Oy Finland'),
	 (9139,244,11,'National','Finland','FI',72,'','Viestintävirasto','Unknown','Unknown','Former Vectone Mobile'),
	 (9140,244,12,'National','Finland','FI',72,'DNA','DNA Oy','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9141,244,13,'National','Finland','FI',72,'DNA','DNA Oy','Not operational','GSM 900 / GSM 1800',''),
	 (9142,244,14,'National','Finland','FI',72,'Ålcom','Ålands Telekommunikation Ab','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800','Former Ålands Mobiltelefon (ÅMT); coverage only in Åland Islands'),
	 (9143,244,15,'National','Finland','FI',72,'SAMK','Satakunnan ammattikorkeakoulu Oy','Not operational','GSM 1800','Educational network of Satakunta University of Applied Sciences; MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9144,244,16,'National','Finland','FI',72,'Tele2','Oy Finland Tele2 AB','Not operational','MVNO','MNC withdrawn'),
	 (9145,244,17,'National','Finland','FI',72,'','Liikennevirasto','Operational','GSM-R','Finnish Transport Agency'),
	 (9146,244,21,'National','Finland','FI',72,'Elisa- Saunalahti','Elisa Oyj','Operational','MVNO','Internal MVNO-code of Elisa Oyj. Former Saunalahti Group Oyj'),
	 (9147,244,22,'National','Finland','FI',72,'','EXFO Oy','Not operational','Unknown','Former NetHawk Oyj; MNC withdrawn'),
	 (9148,244,23,'National','Finland','FI',72,'','EXFO Oy','Not operational','Unknown','Former NetHawk Oyj; MNC withdrawn'),
	 (9149,244,24,'National','Finland','FI',72,'','TTY-säätiö','Not operational','Unknown','Tampere University of Technology foundation; MNC withdrawn'),
	 (9150,244,25,'National','Finland','FI',72,'Datame','Datame Oy','Not operational','CDMA','MNC withdrawn'),
	 (9151,244,26,'National','Finland','FI',72,'Compatel','Compatel Ltd','Operational','MVNO',''),
	 (9152,244,27,'National','Finland','FI',72,'','Teknologian tutkimuskeskus VTT Oy','Unknown','Unknown','VTT Technical Research Centre of Finland'),
	 (9153,244,28,'National','Finland','FI',72,'','Teknologian tutkimuskeskus VTT Oy','Unknown','Unknown','VTT Technical Research Centre of Finland');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9154,244,29,'National','Finland','FI',72,'','SCNL Truphone','Not operational','MVNO','MNC withdrawn'),
	 (9155,244,30,'National','Finland','FI',72,'Vectone Mobile','Mundio Mobile Oy','Not operational','MVNO','MNC withdrawn'),
	 (9156,244,31,'National','Finland','FI',72,'Kuiri','Ukko Mobile Oy','Not operational','MVNO','MNC withdrawn'),
	 (9157,244,32,'National','Finland','FI',72,'Voxbone','Voxbone SA','Operational','MVNO',''),
	 (9158,244,33,'National','Finland','FI',72,'VIRVE','Virve Tuotteet ja Palvelut Oy','Operational','TETRA','Finnish authorities radio network'),
	 (9159,244,34,'National','Finland','FI',72,'Bittium Wireless','Bittium Wireless Oy','Operational','MVNO',''),
	 (9160,244,35,'National','Finland','FI',72,'Ukko Mobile','Ukkoverkot Oy','Operational','LTE 450 / TD-LTE 2600','data-only network'),
	 (9161,244,36,'National','Finland','FI',72,'Sonera / DNA','TeliaSonera Finland Oyj / Suomen Yhteisverkko Oy','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Joint mobile network in Northern and Eastern Finland areas'),
	 (9162,244,37,'National','Finland','FI',72,'Tismi','Tismi BV','Operational','MVNO',''),
	 (9163,244,38,'National','Finland','FI',72,'','Nokia Solutions and Networks Oy','Unknown','Unknown','Test Network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9164,244,39,'National','Finland','FI',72,'','Nokia Solutions and Networks Oy','Unknown','Unknown','Test Network'),
	 (9165,244,40,'National','Finland','FI',72,'','Nokia Solutions and Networks Oy','Unknown','Unknown','Test Network'),
	 (9166,244,41,'National','Finland','FI',72,'','Nokia Solutions and Networks Oy','Unknown','Unknown','Test Network'),
	 (9167,244,42,'National','Finland','FI',72,'','SMS Provider Corp.','Unknown','Unknown',''),
	 (9168,244,43,'National','Finland','FI',72,'','Telavox AB / Telavox Oy','Unknown','Unknown',''),
	 (9169,244,44,'National','Finland','FI',72,'','Turun ammattikorkeakoulu Oy','Unknown','Unknown',''),
	 (9170,244,91,'National','Finland','FI',72,'Sonera','TeliaSonera Finland Oyj','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 700 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9171,244,92,'National','Finland','FI',72,'Sonera','TeliaSonera Finland Oyj','Not operational','Unknown','MNC withdrawn'),
	 (9172,208,1,'National','France','FR',73,'Orange','Orange S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 2600',''),
	 (9173,208,2,'National','France','FR',73,'Orange','Orange S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100','Zones Blanches');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9174,208,3,'National','France','FR',73,'MobiquiThings','MobiquiThings','Operational','MVNO',''),
	 (9175,208,4,'National','France','FR',73,'Sisteer','Societe d''ingenierie systeme telecom et reseaux','Operational','MVNO',''),
	 (9176,208,5,'National','France','FR',73,'','Globalstar Europe','Operational','Satellite',''),
	 (9177,208,6,'National','France','FR',73,'','Globalstar Europe','Operational','Satellite',''),
	 (9178,208,7,'National','France','FR',73,'','Globalstar Europe','Operational','Satellite',''),
	 (9179,208,8,'National','France','FR',73,'SFR','Altice','Operational','MVNO','Former Completel'),
	 (9180,208,9,'National','France','FR',73,'SFR','Altice','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','is launched for SFR outbound roaming services'),
	 (9181,208,10,'National','France','FR',73,'SFR','Altice','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 LTE 2600','MNC also used in Monaco'),
	 (9182,208,11,'National','France','FR',73,'SFR','Altice','Operational','UMTS 2100','Femtocells'),
	 (9183,208,12,'National','France','FR',73,'','Hewlett-Packard France','Not operational','Unknown','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9184,208,13,'National','France','FR',73,'SFR','Altice','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100','Zones Blanches'),
	 (9185,208,14,'National','France','FR',73,'SNCF Réseau','SNCF Réseau','Operational','GSM-R',''),
	 (9186,208,15,'National','France','FR',73,'Free Mobile','Iliad','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600','LTE bands 28 / 3 / 7'),
	 (9187,208,16,'National','France','FR',73,'Free Mobile','Iliad','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600',''),
	 (9188,208,17,'National','France','FR',73,'LEGOS','Local Exchange Global Operation Services','Unknown','Unknown',''),
	 (9189,208,18,'National','France','FR',73,'Voxbone','Voxbone mobile','Not operational','MVNO','MNC withdrawn'),
	 (9190,208,19,'National','France','FR',73,'','Altitude Infrastructure','Unknown','Unknown',''),
	 (9191,208,20,'National','France','FR',73,'Bouygues','Bouygues Telecom','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 700 / LTE 800 / LTE 1800 / LTE 2600','MNC also used in Monaco'),
	 (9192,208,21,'National','France','FR',73,'Bouygues','Bouygues Telecom','Unknown','GSM 900 / GSM 1800 / UMTS 2100 / UMTS 900',''),
	 (9193,208,22,'National','France','FR',73,'Transatel Mobile','Transatel','Unknown','Unknown','MVNE Uses Orange');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9194,208,23,'National','France','FR',73,'','Omea Telecom','Not operational','MVNO','Used by Virgin Mobile France, Breizh Mobile, Tele2 Mobile, Mobile Casino; uses only SFR, was bought by SFR in 2014; MNC withdrawn'),
	 (9195,208,24,'National','France','FR',73,'MobiquiThings','MobiquiThings','Operational','MVNO',''),
	 (9196,208,25,'National','France','FR',73,'LycaMobile','LycaMobile','Operational','MVNO',''),
	 (9197,208,26,'National','France','FR',73,'NRJ Mobile','Euro-Information Telecom SAS','Operational','MVNO','Uses SFR, Orange and Bouygues Telecom'),
	 (9198,208,27,'National','France','FR',73,'Bouygues Coriolis','Coriolis Telecom','Operational','MVNO','Former Afone'),
	 (9199,208,28,'National','France','FR',73,'','Airbus Defence and Space SAS','Unknown','Unknown',''),
	 (9200,208,29,'National','France','FR',73,'','Cubic Telecom France','Not operational','MVNO','Former Société International Mobile Communication; MNC withdrawn'),
	 (9201,208,30,'National','France','FR',73,'Syma Mobile','Syma Mobile','Operational','MVNO',''),
	 (9202,208,31,'National','France','FR',73,'Vectone Mobile','Mundio Mobile','Operational','MVNO','Uses SFR  or RED'),
	 (9203,208,32,'National','France','FR',73,'Orange','Orange S.A.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9204,208,86,'National','France','FR',73,'','Nomotech','Unknown','Unknown',''),
	 (9205,208,87,'National','France','FR',73,'RATP','Régie autonome des transports parisiens','Unknown','Unknown',''),
	 (9206,208,88,'National','France','FR',73,'Bouygues','Bouygues Telecom','Operational','GSM 900 / GSM 1800','Zones Blanches'),
	 (9207,208,89,'National','France','FR',73,'','Fondation b-com','Unknown','Unknown','former Omer Telecom Ltd'),
	 (9208,208,90,'National','France','FR',73,'','Images & Réseaux','Not operational','Unknown','MNC withdrawn'),
	 (9209,208,91,'National','France','FR',73,'','Orange S.A.','Unknown','Unknown',''),
	 (9210,208,92,'National','France','FR',73,'Com4Innov','Association Plate-forme Télécom','Not operational','TD-LTE 2300 / LTE 2600','Test network; MNC withdrawn'),
	 (9211,208,93,'National','France','FR',73,'','Thales Communications & Security SAS','Unknown','Unknown','Former TDF'),
	 (9212,208,94,'National','France','FR',73,'','Halys','Unknown','Unknown',''),
	 (9213,208,95,'National','France','FR',73,'','Orange S.A.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9214,208,96,'National','France','FR',73,'','Axione','Unknown','Unknown',''),
	 (9215,208,97,'National','France','FR',73,'','Thales Communications & Security SAS','Unknown','Unknown',''),
	 (9216,208,98,'National','France','FR',73,'','Société Air France','Unknown','Unknown',''),
	 (9217,340,1,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'Orange','Orange Caraïbe Mobiles','Operational','GSM 900 / UMTS 2100 / LTE 1800 / LTE 2100','Guadeloupe, French Guiana, Martinique, Saint Barthélemy, Saint Martin'),
	 (9218,340,2,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'SFR Caraïbe','Outremer Telecom','Operational','GSM 900 / GSM 1800 / UMTS / LTE','Guadeloupe, French Guiana, Martinique; former Only'),
	 (9219,340,3,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'Chippie','UTS Caraïbe','Operational','GSM 900 / GSM 1800 / UMTS / LTE 1800','Saint Barthélemy, Saint Martin; former Telcell'),
	 (9220,340,8,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'Dauphin','Dauphin Telecom','Operational','GSM 900 / GSM 1800 / UMTS','Saint Barthélemy, Saint Martin'),
	 (9221,340,9,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'Free','Free Mobile','Unknown','Unknown','Guadeloupe'),
	 (9222,340,10,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'','Guadeloupe Téléphone Mobile','Not operational','Unknown',''),
	 (9223,340,11,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'','Guyane Téléphone Mobile','Not operational','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9224,340,12,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'','Martinique Téléphone Mobile','Not operational','Unknown',''),
	 (9225,340,20,'National','French Antilles (France)','BL/GF/GP/MF/MQ',0,'Digicel','DIGICEL Antilles Française Guyane','Operational','GSM 900 / UMTS 2100','Guadeloupe, French Guiana, Martinique, Saint Barthélemy, Saint Martin; former Bouygues Telecom Caraïbes'),
	 (9226,647,0,'National','French Indian Ocean Territories (France)','YT/RE',0,'Orange','Orange La Réunion','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Mayotte, Réunion'),
	 (9227,647,1,'National','French Indian Ocean Territories (France)','YT/RE',0,'','BJT Partners','Unknown','GSM 900 / GSM 1800','Mayotte'),
	 (9228,647,2,'National','French Indian Ocean Territories (France)','YT/RE',0,'Free','Telco OI','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Mayotte, Réunion; former Outremer Telecom, Only'),
	 (9229,647,3,'National','French Indian Ocean Territories (France)','YT/RE',0,'Free','Telco OI','Unknown','Unknown','Former Only'),
	 (9230,647,4,'National','French Indian Ocean Territories (France)','YT/RE',0,'4G Réunion','Zeop mobile','Unknown','LTE',''),
	 (9231,647,10,'National','French Indian Ocean Territories (France)','YT/RE',0,'SFR Réunion','Société Réunionnaise du Radiotéléphone','Operational','GSM 900 / LTE 800 / LTE 1800 / LTE 2600','Mayotte, Réunion; LTE bands 20 / 3 / 7'),
	 (9232,547,5,'National','French Polynesia (France)','PF',75,'Ora','VITI','Operational','WiMAX / LTE 800 / LTE 2600',''),
	 (9233,547,10,'National','French Polynesia (France)','PF',75,'','Mara Telecom','Not operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9234,547,15,'National','French Polynesia (France)','PF',75,'Vodafone','Pacific Mobile Telecom','Operational','GSM 900 / UMTS 2100',''),
	 (9235,547,20,'National','French Polynesia (France)','PF',75,'Vini','Tikiphone SA','Operational','GSM 900 / UMTS 2100 / LTE',''),
	 (9236,0,0,'National','French Southern Territories (France)','TF',76,'','','','',''),
	 (9237,628,1,'National','Gabon','GA',77,'Libertis','Gabon Telecom & Libertis S.A.','Operational','GSM 900 / LTE',''),
	 (9238,628,2,'National','Gabon','GA',77,'Moov','Atlantique Télécom (Etisalat Group) Gabon S.A.','Operational','GSM 900 / LTE',''),
	 (9239,628,3,'National','Gabon','GA',77,'Airtel','Airtel Gabon S.A.','Operational','GSM 900 / LTE',''),
	 (9240,628,4,'National','Gabon','GA',77,'Azur','USAN Gabon S.A.','Operational','GSM 900 / GSM 1800',''),
	 (9241,628,5,'National','Gabon','GA',77,'RAG','Réseau de l’Administration Gabonaise','Unknown','Unknown',''),
	 (9242,607,1,'National','Gambia','GM',78,'Gamcel','Gamcel','Operational','GSM 900 / GSM 1800',''),
	 (9243,607,2,'National','Gambia','GM',78,'Africell','Africell','Operational','GSM 900 / GSM 1800 / LTE','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9244,607,3,'National','Gambia','GM',78,'Comium','Comium','Operational','GSM 900 / GSM 1800',''),
	 (9245,607,4,'National','Gambia','GM',78,'QCell','QCell Gambia','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE',''),
	 (9246,607,5,'National','Gambia','GM',78,'','GAMTEL-Ecowan','Unknown','WiMAX / LTE',''),
	 (9247,607,6,'National','Gambia','GM',78,'','NETPAGE','Operational','TD-LTE 2300',''),
	 (9248,282,1,'National','Georgia','GE',79,'Geocell','Geocell Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9249,282,2,'National','Georgia','GE',79,'MagtiCom','Magticom GSM','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9250,282,3,'National','Georgia','GE',79,'MagtiCom','Magtifix','Operational','CDMA 450',''),
	 (9251,282,4,'National','Georgia','GE',79,'Beeline','Mobitel LLC','Operational','GSM 1800 / UMTS 2100 / LTE 800',''),
	 (9252,282,5,'National','Georgia','GE',79,'Silknet','JSC Silknet','Operational','CDMA 800','former UTG'),
	 (9253,282,6,'National','Georgia','GE',79,'','JSC Compatel','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9254,282,7,'National','Georgia','GE',79,'GlobalCell','GlobalCell Ltd','Operational','MVNO',''),
	 (9255,282,8,'National','Georgia','GE',79,'Silk LTE','JSC Silknet','Operational','TD-LTE 2300',''),
	 (9256,282,9,'National','Georgia','GE',79,'','Gmobile Ltd','Operational','Unknown',''),
	 (9257,262,1,'National','Germany','DE',80,'Telekom','Telekom Deutschland GmbH','Operational','GSM 900 / GSM 1800/ / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2600','Formerly D1 - DeTeMobil, D1-Telekom, T-D1, T-Mobile'),
	 (9258,262,2,'National','Germany','DE',80,'Vodafone','Vodafone D2 GmbH','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former D2 Mannesmann'),
	 (9259,262,3,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former E-Plus, until 2014'),
	 (9260,262,4,'National','Germany','DE',80,'Vodafone','Vodafone D2 GmbH','Reserved','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9261,262,5,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Reserved','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100','Former E-Plus'),
	 (9262,262,6,'National','Germany','DE',80,'Telekom','Telekom Deutschland GmbH','Reserved','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2600',''),
	 (9263,262,7,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Not operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Merged with E-Plus Mobilfunk in 2014 and uses MNC 262-03 since 2016');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9264,262,8,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Reserved','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9265,262,9,'National','Germany','DE',80,'Vodafone','Vodafone D2 GmbH','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','Internal testing IOT'),
	 (9266,262,10,'National','Germany','DE',80,'','DB Netz AG','Operational','GSM-R','Former Arcor, Vodafone'),
	 (9267,262,11,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Reserved','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9268,262,12,'National','Germany','DE',80,'Dolphin Telecom','sipgate GmbH','Operational','MVNO','National roaming with O2 (former E-Plus)'),
	 (9269,262,13,'National','Germany','DE',80,'','Mobilcom Multimedia','Not operational','UMTS 2100','License returned in 2003, MNC withdrawn'),
	 (9270,262,14,'National','Germany','DE',80,'','Group 3G UMTS','Not operational','UMTS 2100','License revoked in 2007, MNC withdrawn'),
	 (9271,262,15,'National','Germany','DE',80,'Airdata','','Operational','TD-SCDMA','data only'),
	 (9272,262,16,'National','Germany','DE',80,'','Telogic Germany GmbH','Not operational','MVNO','formerly Vistream; bankruptcy in 2012'),
	 (9273,262,17,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Unknown','Unknown','Former E-Plus');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9274,262,18,'National','Germany','DE',80,'','NetCologne','Operational','MVNO','also CDMA 450'),
	 (9275,262,19,'National','Germany','DE',80,'','Inquam Deutschland','Unknown','CDMA 450',''),
	 (9276,262,20,'National','Germany','DE',80,'Voiceworks','Voiceworks GmbH','Operational','MVNE','Uses O2 (former E-Plus) (262-03)'),
	 (9277,262,21,'National','Germany','DE',80,'','Multiconnect GmbH','Unknown','Unknown',''),
	 (9278,262,22,'National','Germany','DE',80,'','sipgate Wireless GmbH','Unknown','MVNO',''),
	 (9279,262,23,'National','Germany','DE',80,'','Drillisch Online AG','Operational','MVNO',''),
	 (9280,262,33,'National','Germany','DE',80,'simquadrat','sipgate GmbH','Operational','MVNO','Uses O2 (former E-Plus) (262-03)'),
	 (9281,262,41,'National','Germany','DE',80,'','First Telecom GmbH','Not operational','Unknown','MNC withdrawn'),
	 (9282,262,42,'National','Germany','DE',80,'CCC Event','Chaos Computer Club','Temporary operational','GSM 1800','Used on events like Chaos Communication Congress'),
	 (9283,262,43,'National','Germany','DE',80,'Lycamobile','Lycamobile','Operational','MVNO','Uses Vodafone');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9284,262,60,'National','Germany','DE',80,'','DB Telematik','Operational','GSM-R 900',''),
	 (9285,262,72,'National','Germany','DE',80,'','Ericsson GmbH','Unknown','Unknown',''),
	 (9286,262,73,'National','Germany','DE',80,'','Xantaro Deutschland GmbH','Unknown','Unknown',''),
	 (9287,262,74,'National','Germany','DE',80,'','Qualcomm CDMA Technologies GmbH','Unknown','Unknown',''),
	 (9288,262,75,'National','Germany','DE',80,'','Core Network Dynamics GmbH','Not operational','','Test network'),
	 (9289,262,76,'National','Germany','DE',80,'','Siemens AG','Not operational','GSM 900','Test network; MNC withdrawn'),
	 (9290,262,77,'National','Germany','DE',80,'O2','Telefónica Germany GmbH & Co. oHG','Unknown','GSM 900','Former E-Plus; test network'),
	 (9291,262,78,'National','Germany','DE',80,'Telekom','Telekom Deutschland GmbH','Unknown','Unknown',''),
	 (9292,262,79,'National','Germany','DE',80,'','ng4T GmbH','Not operational','Unknown','MNC withdrawn'),
	 (9293,262,92,'National','Germany','DE',80,'','Nash Technologies','Operational','GSM 1800 / UMTS 2100','Test network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9294,620,1,'National','Ghana','GH',81,'MTN','MTN Group','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800','former spacefon'),
	 (9295,620,2,'National','Ghana','GH',81,'Vodafone','Vodafone Group','Operational','GSM 900 / GSM 1800 / UMTS / LTE 1800','former Onetouch'),
	 (9296,620,3,'National','Ghana','GH',81,'AirtelTigo','Millicom Ghana','Operational','GSM 900 / GSM 1800 / UMTS','former MOBITEL, Tigo'),
	 (9297,620,4,'National','Ghana','GH',81,'Expresso','Kasapa / Hutchison Telecom','Operational','CDMA2000 850','former Kasapa'),
	 (9298,620,6,'National','Ghana','GH',81,'AirtelTigo','Airtel','Operational','GSM 900 / GSM 1800 / UMTS','former Zain, Airtel'),
	 (9299,620,7,'National','Ghana','GH',81,'Globacom','Globacom Group','Operational','GSM 900 / GSM 1800 / UMTS',''),
	 (9300,620,8,'National','Ghana','GH',81,'Surfline','Surfline Communications Ltd','Operational','LTE 2600','LTE band 7'),
	 (9301,620,10,'National','Ghana','GH',81,'Blu','Blu Telecommunications','Operational','TD-LTE 2600','LTE band 38'),
	 (9302,620,11,'National','Ghana','GH',81,'','Netafrique Dot Com Ltd','Unknown','Unknown',''),
	 (9303,266,1,'National','Gibraltar (United Kingdom)','GI',82,'GibTel','Gibtelecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9304,266,6,'National','Gibraltar (United Kingdom)','GI',82,'CTS Mobile','CTS Gibraltar','Not operational','UMTS 2100','licence withdrawn in February 2013'),
	 (9305,266,9,'National','Gibraltar (United Kingdom)','GI',82,'Shine','Eazitelecom','Operational','GSM 1800 / UMTS 2100',''),
	 (9306,202,1,'National','Greece','GR',83,'Cosmote','COSMOTE - Mobile Telecommunications S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9307,202,2,'National','Greece','GR',83,'Cosmote','COSMOTE - Mobile Telecommunications S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9308,202,3,'National','Greece','GR',83,'','OTE','Unknown','Unknown',''),
	 (9309,202,4,'National','Greece','GR',83,'','OSE','Unknown','GSM-R','Former EDISY'),
	 (9310,202,5,'National','Greece','GR',83,'Vodafone','Vodafone Greece','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','former PanaFon'),
	 (9311,202,6,'National','Greece','GR',83,'','Cosmoline','Not operational','Unknown','MNC withdrawn'),
	 (9312,202,7,'National','Greece','GR',83,'','AMD Telecom','Unknown','Unknown',''),
	 (9313,202,9,'National','Greece','GR',83,'Wind','Wind Hellas Telecommunications S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','former Q-Telecom');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9314,202,10,'National','Greece','GR',83,'Wind','Wind Hellas Telecommunications S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','former Telestet & TIM'),
	 (9315,202,11,'National','Greece','GR',83,'','interConnect','Unknown','Unknown',''),
	 (9316,202,12,'National','Greece','GR',83,'','Yuboto','Operational','MVNO',''),
	 (9317,202,13,'National','Greece','GR',83,'','Compatel Limited','Unknown','Unknown',''),
	 (9318,202,14,'National','Greece','GR',83,'Cyta Hellas','CYTA','Operational','MVNO','MVNO on Vodafone''s network'),
	 (9319,202,15,'National','Greece','GR',83,'','BWS','Unknown','Unknown',''),
	 (9320,202,16,'National','Greece','GR',83,'','Inter Telecom','Operational','MVNO',''),
	 (9321,290,1,'National','Greenland (Kingdom of Denmark)','GL',84,'TELE Greenland  A/S','TELE Greenland A/S','Operational','GSM 900 / UMTS 900 / LTE 800',''),
	 (9322,290,2,'National','Greenland (Kingdom of Denmark)','GL',84,'Nuuk TV','inu:it a/s','Operational','TD-LTE 2500',''),
	 (9323,352,30,'National','Grenada','GD',85,'Digicel','Digicel Grenada Ltd.','Operational','GSM 900 / GSM 1800','Also uses MCC 338 MNC 05 (Jamaica)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9324,352,110,'National','Grenada','GD',85,'FLOW','Cable & Wireless Grenada Ltd.','Operational','GSM 850',''),
	 (9325,310,32,'National','Guam (United States of America)','GU',87,'IT&E Wireless','IT&E Overseas, Inc','Operational','CDMA 1900 / GSM 1900 / LTE 700',''),
	 (9326,310,33,'National','Guam (United States of America)','GU',87,'','Guam Telephone Authority','Unknown','Unknown',''),
	 (9327,310,140,'National','Guam (United States of America)','GU',87,'GTA Wireless','Teleguam Holdings, LLC','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 1700','Previously called Guam Telephone Authority mPulse'),
	 (9328,310,370,'National','Guam (United States of America)','GU',87,'Docomo','NTT Docomo Pacific','Operational','GSM 1900 / UMTS 850 / LTE 700','Formerly HafaTEL, then Guamcell; CDMA 850 shut down in late 2010; some sources also list MCC 310 MNC 470 for Docomo'),
	 (9329,310,400,'National','Guam (United States of America)','GU',87,'iConnect','Wave Runner LLC','Operational','GSM 1900 / UMTS 1900 / LTE 700',''),
	 (9330,310,480,'National','Guam (United States of America)','GU',87,'iConnect','Wave Runner LLC','Operational','iDEN',''),
	 (9331,311,120,'National','Guam (United States of America)','GU',87,'iConnect','Wave Runner LLC','Operational','Unknown',''),
	 (9332,311,250,'National','Guam (United States of America)','GU',87,'iConnect','Wave Runner LLC','Operational','Unknown',''),
	 (9333,704,1,'National','Guatemala','GT',88,'Claro','Telecomunicaciones de Guatemala, S.A.','Operational','CDMA 1900 / GSM 900 / GSM 1900 / UMTS 1900','former Servicios de Comunicaciones Personales Inalambricas (SERCOM)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9334,704,2,'National','Guatemala','GT',88,'Tigo','Millicom / Local partners','Operational','GSM 850 / TDMA 800 / UMTS 850 / LTE 850','former COMCEL'),
	 (9335,704,3,'National','Guatemala','GT',88,'movistar','Telefónica Móviles Guatemala (Telefónica)','Operational','CDMA 1900 / GSM 1900 / UMTS 1900 / LTE 1900',''),
	 (9336,704,0,'National','Guatemala','GT',88,'digicel','Digicel Group','Reserved','GSM 900',''),
	 (9338,234,3,'National','Guernsey (United Kingdom)','GG',246,'Airtel-Vodafone','Guernsey Airtel Ltd','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9339,234,50,'National','Guernsey (United Kingdom)','GG',246,'JT','JT Group Limited','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','former Wave Telecom'),
	 (9340,234,55,'National','Guernsey (United Kingdom)','GG',246,'Sure Mobile','Sure (Guernsey) Limited','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800','former Cable & Wireless'),
	 (9341,611,1,'National','Guinea','GN',89,'Orange','Orange S.A.','Operational','GSM 900 / GSM 1800','Formerly Spacetel'),
	 (9342,611,2,'National','Guinea','GN',89,'Sotelgui','Sotelgui Lagui','Operational','GSM 900',''),
	 (9343,611,3,'National','Guinea','GN',89,'Telecel Guinee','INTERCEL Guinée','Operational','GSM 900',''),
	 (9344,611,4,'National','Guinea','GN',89,'MTN','Areeba Guinea','Operational','GSM 900 / GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9345,611,5,'National','Guinea','GN',89,'Cellcom','Cellcom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9346,632,1,'National','Guinea-Bissau','GW',90,'Guinetel','Guinétel S.A.','Operational','GSM 900 / GSM 1800',''),
	 (9347,632,2,'National','Guinea-Bissau','GW',90,'MTN Areeba','Spacetel Guiné-Bissau S.A.','Operational','GSM 900 / GSM 1800',''),
	 (9348,632,3,'National','Guinea-Bissau','GW',90,'Orange','','Operational','GSM 900 / GSM 1800 / LTE',''),
	 (9349,632,7,'National','Guinea-Bissau','GW',90,'Guinetel','Guinétel S.A.','Operational','GSM 900 / GSM 1800',''),
	 (9350,738,1,'National','Guyana','GY',91,'Digicel','U-Mobile (Cellular) Inc.','Operational','GSM 900',''),
	 (9351,738,2,'National','Guyana','GY',91,'GT&T Cellink Plus','Guyana Telephone & Telegraph Co.','Operational','GSM 900 / LTE',''),
	 (9352,738,3,'National','Guyana','GY',91,'','Quark Communications Inc.','Unknown','TD-LTE',''),
	 (9353,738,5,'National','Guyana','GY',91,'','eGovernment Unit, Ministry of the Presidency','Unknown','Unknown',''),
	 (9354,372,1,'National','Haiti','HT',92,'Voila','Communication Cellulaire d''Haiti S.A.','Not operational','GSM 850','Sold to Digicel in 2012');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9355,372,2,'National','Haiti','HT',92,'Digicel','Unigestion Holding S.A.','Operational','GSM 1800',''),
	 (9356,372,3,'National','Haiti','HT',92,'Natcom','NATCOM S.A.','Operational','GSM 900 / GSM 1800 / UTMS 2100 / LTE','60% owned by Viettel'),
	 (9357,708,1,'National','Honduras','HN',95,'Claro','Servicios de Comunicaciones de Honduras S.A. de C.V.','Operational','GSM 1900 / UMTS 1900 / LTE 1700',''),
	 (9358,708,2,'National','Honduras','HN',95,'Tigo','Celtel','Operational','CDMA 850 / GSM 850 / UMTS 850 / LTE 1700','also uses or has used MNC 02'),
	 (9359,708,30,'National','Honduras','HN',95,'Hondutel','Empresa Hondureña de Telecomunicaciones','Operational','GSM 1900',''),
	 (9360,708,40,'National','Honduras','HN',95,'Digicel','Digicel de Honduras','Operational','GSM 1900',''),
	 (9361,454,0,'National','Hong Kong','HK',96,'1O1O / One2Free / New World Mobility / SUNMobile','CSL Limited','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (9362,454,1,'National','Hong Kong','HK',96,'','CITIC Telecom 1616','Operational','MVNO','MVNO on CSL network; network code operational only at land borders and Airport to attract inbound roamers to join 454-00'),
	 (9363,454,2,'National','Hong Kong','HK',96,'','CSL Limited','Operational','GSM 900 / GSM 1800','Network code operational only at land borders and Airport to attract inbound roamers to join 454-00'),
	 (9364,454,3,'National','Hong Kong','HK',96,'3','Hutchison Telecom','Operational','UMTS 900 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9365,454,4,'National','Hong Kong','HK',96,'3 (2G)','Hutchison Telecom','Operational','GSM 900 / GSM 1800',''),
	 (9366,454,5,'National','Hong Kong','HK',96,'3 (CDMA)','Hutchison Telecom','Not operational','CDMA 800','Defunct CDMA IS-95 network, decommissioned on 19 November 2008 at 23:59'),
	 (9367,454,6,'National','Hong Kong','HK',96,'SmarTone','SmarTone Mobile Communications Limited','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2600',''),
	 (9368,454,7,'National','Hong Kong','HK',96,'China Unicom','China Unicom (Hong Kong) Limited','Operational','MVNO','MVNO on PCCW Mobile network code operational only at land borders and Airport to attract inbound roamers to join 454-16 or 454-19'),
	 (9369,454,8,'National','Hong Kong','HK',96,'Truphone','Truphone Limited','Operational','MVNO','Former Trident'),
	 (9370,454,9,'National','Hong Kong','HK',96,'','China Motion Telecom','Operational','MVNO','MVNO on CSL network'),
	 (9371,454,10,'National','Hong Kong','HK',96,'New World Mobility','CSL Limited','Not operational','GSM 1800','Signal Combined with 454-00'),
	 (9372,454,11,'National','Hong Kong','HK',96,'','China-Hong Kong Telecom','Operational','MVNO','MVNO on PCCW Mobile and Hutchison Telecom networks'),
	 (9373,454,12,'National','Hong Kong','HK',96,'CMCC HK','China Mobile Hong Kong Company Limited','Operational','GSM 1800 / LTE 1800 / TD-LTE 2300 / LTE 2600','Formerly Peoples'),
	 (9374,454,13,'National','Hong Kong','HK',96,'CMCC HK','China Mobile Hong Kong Company Limited','Operational','MVNO','MVNO on PCCW Mobile (3G)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9375,454,14,'National','Hong Kong','HK',96,'','Hutchison Telecom','Operational','GSM 900 / GSM 1800','Network code operational only at land borders and Airport to attract inbound roamers to join 454-03 or 454-04'),
	 (9376,454,15,'National','Hong Kong','HK',96,'','SmarTone Mobile Communications Limited','Operational','GSM 1800','Network code operational only at land borders and Airport to attract inbound roamers to join 454-06'),
	 (9377,454,16,'National','Hong Kong','HK',96,'PCCW Mobile (2G)','PCCW','Operational','GSM 1800','Formerly SUNDAY'),
	 (9378,454,17,'National','Hong Kong','HK',96,'','SmarTone Mobile Communications Limited','Operational','GSM 1800','Network code operational only at land borders and Airport to attract inbound roamers to join 454-06'),
	 (9379,454,18,'National','Hong Kong','HK',96,'','CSL Limited','Not operational','GSM 900 / GSM 1800',''),
	 (9380,454,19,'National','Hong Kong','HK',96,'PCCW Mobile (3G)','PCCW-HKT','Operational','UMTS 2100',''),
	 (9381,454,20,'National','Hong Kong','HK',96,'PCCW Mobile (4G)','PCCW-HKT','Operational','LTE 1800 / LTE 2600',''),
	 (9382,454,21,'National','Hong Kong','HK',96,'','21Vianet Mobile Ltd.','Unknown','MVNO',''),
	 (9383,454,22,'National','Hong Kong','HK',96,'','263 Mobile Communications (HongKong) Limited','Operational','MVNO','Formerly P Plus Communications, Delcom (HK) Ltd'),
	 (9384,454,23,'National','Hong Kong','HK',96,'Lycamobile','Lycamobile Hong Kong Ltd','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9385,454,24,'National','Hong Kong','HK',96,'','Multibyte Info Technology Ltd','Operational','MVNO',''),
	 (9386,454,25,'National','Hong Kong','HK',96,'','Hong Kong Government','Unknown','Unknown',''),
	 (9387,454,26,'National','Hong Kong','HK',96,'','Hong Kong Government','Unknown','Unknown',''),
	 (9388,454,29,'National','Hong Kong','HK',96,'PCCW Mobile (CDMA)','PCCW-HKT','Operational','CDMA 800','CDMA2000 1xEV-DO Rev A network for inbound roamers, with limited coverage'),
	 (9389,454,30,'National','Hong Kong','HK',96,'','China Data Enterprises Ltd','Unknown','Unknown',''),
	 (9390,454,31,'National','Hong Kong','HK',96,'CTExcel','China Telecom Global Limited','Operational','MVNO',''),
	 (9391,454,32,'National','Hong Kong','HK',96,'','Hong Kong Broadband Network Ltd','Operational','MVNO',''),
	 (9392,454,35,'National','Hong Kong','HK',96,'','Webbing Hong Kong Ltd','Operational','MVNO',''),
	 (9393,216,1,'National','Hungary','HU',97,'Telenor Hungary','Telenor Magyarország Zrt.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Pannon, Pannon GSM; MNC has not the same numerical value as the area code'),
	 (9394,216,2,'National','Hungary','HU',97,'','MVM Net Ltd.','Operational','LTE 450','For government use');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9395,216,3,'National','Hungary','HU',97,'DIGI','DIGI Telecommunication Ltd.','Not operational','LTE 1800','Planned'),
	 (9396,216,4,'National','Hungary','HU',97,'','Invitech Solutions','Unknown','Unknown',''),
	 (9397,216,30,'National','Hungary','HU',97,'T-Mobile','Magyar Telekom Plc','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former WESTEL, Westel 900; MNC has the same numerical value as the area code'),
	 (9398,216,70,'National','Hungary','HU',97,'Vodafone','Vodafone Magyarország Zrt.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / UMTS 900 / LTE 800 / LTE 1800 / LTE 2600','MNC has the same numerical value as the area code'),
	 (9399,216,71,'National','Hungary','HU',97,'upc','UPC Hungary Ltd.','Operational','MVNO',''),
	 (9400,216,99,'National','Hungary','HU',97,'MAV GSM-R','Magyar Államvasutak','Planned','GSM-R 900',''),
	 (9401,274,1,'National','Iceland','IS',98,'Síminn','Iceland Telecom','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800','Former Landssimi hf'),
	 (9402,274,2,'National','Iceland','IS',98,'Vodafone','Og fjarskipti hf','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Former Islandssimi ehf'),
	 (9403,274,3,'National','Iceland','IS',98,'Vodafone','Og fjarskipti hf','Operational','Unknown','Former Islandssimi ehf'),
	 (9404,274,4,'National','Iceland','IS',98,'Viking','IMC Island ehf','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9405,274,5,'National','Iceland','IS',98,'','Halló Frjáls fjarskipti hf.','Not operational','GSM 1800','MNC withdrawn'),
	 (9406,274,6,'National','Iceland','IS',98,'','Núll níu ehf','Not operational','Unknown','MNC withdrawn'),
	 (9407,274,7,'National','Iceland','IS',98,'IceCell','IceCell ehf','Not operational','GSM 1800','Network never built; MNC withdrawn'),
	 (9408,274,8,'National','Iceland','IS',98,'On-waves','Iceland Telecom','Operational','GSM 900 / GSM 1800','On ferries and cruise ships'),
	 (9409,274,11,'National','Iceland','IS',98,'Nova','Nova ehf','Operational','UMTS 2100 / LTE 1800',''),
	 (9410,274,12,'National','Iceland','IS',98,'Tal','IP fjarskipti','Operational','MVNO',''),
	 (9411,274,16,'National','Iceland','IS',98,'','Tismi BV','Unknown','Unknown',''),
	 (9412,274,22,'National','Iceland','IS',98,'','Landhelgisgæslan (Icelandic Coast Guard)','Unknown','Unknown',''),
	 (9413,274,31,'National','Iceland','IS',98,'Síminn','Iceland Telecom','Unknown','Unknown',''),
	 (9414,404,1,'National','India','IN',99,'Vodafone India','Haryana','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9415,404,2,'National','India','IN',99,'AirTel','Punjab','Operational','GSM 900',''),
	 (9416,404,3,'National','India','IN',99,'AirTel','Himachal Pradesh','Operational','GSM 900',''),
	 (9417,404,4,'National','India','IN',99,'IDEA','Delhi & NCR','Operational','GSM 1800',''),
	 (9418,404,5,'National','India','IN',99,'Vodafone India','Gujarat','Operational','GSM 900','Formerly Hutch / Fascel'),
	 (9419,404,7,'National','India','IN',99,'IDEA','Andhra Pradesh and Telangana','Operational','GSM 900',''),
	 (9420,404,9,'National','India','IN',99,'Reliance','Assam','Operational','GSM 900',''),
	 (9421,404,10,'National','India','IN',99,'AirTel','Delhi & NCR','Operational','GSM 900',''),
	 (9422,404,11,'National','India','IN',99,'Vodafone India','Delhi & NCR','Operational','GSM 900 / GSM 1800',''),
	 (9423,404,12,'National','India','IN',99,'IDEA','Haryana','Operational','GSM 900','Former Escotel'),
	 (9424,404,13,'National','India','IN',99,'Vodafone India','Andhra Pradesh and Telangana','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9425,404,14,'National','India','IN',99,'IDEA','Punjab','Operational','GSM 900 / GSM 1800','Former Spice'),
	 (9426,404,15,'National','India','IN',99,'Vodafone India','Uttar Pradesh (East)','Operational','GSM 900',''),
	 (9427,404,16,'National','India','IN',99,'Airtel','North East','Operational','GSM 900','Former Hexacom'),
	 (9428,404,17,'National','India','IN',99,'AIRCEL','West Bengal','Operational','GSM 900 / GSM 1800',''),
	 (9429,404,18,'National','India','IN',99,'Reliance','Himachal Pradesh','Operational','GSM 900',''),
	 (9430,404,19,'National','India','IN',99,'IDEA','Kerala','Operational','GSM 900 / GSM 1800','Former Escotel'),
	 (9431,404,20,'National','India','IN',99,'Vodafone India','Mumbai','Operational','GSM 900 / UMTS 2100','Former Hutchison Maxtouch / Orange / Hutch'),
	 (9432,404,21,'National','India','IN',99,'Loop Mobile','Mumbai','Operational','GSM 900','Former BPL Mobile'),
	 (9433,404,22,'National','India','IN',99,'IDEA','Maharashtra & Goa','Operational','GSM 900',''),
	 (9434,404,24,'National','India','IN',99,'IDEA','Gujarat','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9435,404,25,'National','India','IN',99,'AIRCEL','Bihar','Operational','GSM 900 / GSM 1800',''),
	 (9436,404,27,'National','India','IN',99,'Vodafone India','Maharashtra & Goa','Operational','GSM 900',''),
	 (9437,404,28,'National','India','IN',99,'AIRCEL','Orissa','Operational','GSM 900',''),
	 (9438,404,29,'National','India','IN',99,'AIRCEL','Assam','Operational','GSM 900',''),
	 (9439,404,30,'National','India','IN',99,'Vodafone India','Kolkata','Operational','GSM 900 / GSM 1800','Former Command / Hutch'),
	 (9440,404,31,'National','India','IN',99,'AirTel','Kolkata','Operational','GSM 900',''),
	 (9441,404,34,'National','India','IN',99,'cellone','Haryana','Operational','GSM 900 / UMTS 2100',''),
	 (9442,404,36,'National','India','IN',99,'Reliance','Bihar & Jharkhand','Operational','GSM 900',''),
	 (9443,404,37,'National','India','IN',99,'Aircel','Jammu & Kashmir','Operational','GSM 900 / UMTS 2100',''),
	 (9444,404,38,'National','India','IN',99,'cellone','Assam','Operational','GSM 900 / UMTS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9445,404,40,'National','India','IN',99,'AirTel','Chennai','Operational','Unknown',''),
	 (9446,404,41,'National','India','IN',99,'Aircel','Chennai','Operational','GSM 900','Formerly RPG'),
	 (9447,404,42,'National','India','IN',99,'Aircel','Tamil Nadu','Operational','GSM 900',''),
	 (9448,404,43,'National','India','IN',99,'Vodafone India','Tamil Nadu','Operational','GSM 900',''),
	 (9449,404,44,'National','India','IN',99,'IDEA','Karnataka','Operational','GSM 900 / LTE 1800','Former Spice'),
	 (9450,404,45,'National','India','IN',99,'Airtel','Karnataka','Operational','GSM / TD-LTE 2300',''),
	 (9451,404,46,'National','India','IN',99,'Vodafone India','Kerala','Operational','GSM 900',''),
	 (9452,404,48,'National','India','IN',99,'Dishnet Wireless','Unknown','Operational','GSM 900',''),
	 (9453,404,49,'National','India','IN',99,'Airtel','Andhra Pradesh and Telangana','Operational','GSM 900',''),
	 (9454,404,50,'National','India','IN',99,'Reliance','North East','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9455,404,51,'National','India','IN',99,'cellone','Himachal Pradesh','Operational','GSM 900 / UMTS 2100',''),
	 (9456,404,52,'National','India','IN',99,'Reliance','Orissa','Operational','GSM 900',''),
	 (9457,404,53,'National','India','IN',99,'cellone','Punjab','Operational','GSM 900 / UMTS 2100',''),
	 (9458,404,54,'National','India','IN',99,'cellone','Uttar Pradesh (West)','Operational','GSM 900 / UTMS 2100',''),
	 (9459,404,55,'National','India','IN',99,'cellone','Uttar Pradesh (East)','Operational','GSM 900 / UTMS 2100',''),
	 (9460,404,56,'National','India','IN',99,'IDEA','Uttar Pradesh (West)','Operational','GSM 900',''),
	 (9461,404,57,'National','India','IN',99,'cellone','Gujarat','Operational','GSM 900 / UMTS 2100',''),
	 (9462,404,58,'National','India','IN',99,'cellone','Madhya Pradesh & Chhattisgarh','Operational','GSM 900 / UMTS 2100',''),
	 (9463,404,59,'National','India','IN',99,'cellone','Rajasthan','Operational','GSM 900 / UMTS 2100',''),
	 (9464,404,60,'National','India','IN',99,'Vodafone India','Rajasthan','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9465,404,62,'National','India','IN',99,'cellone','Jammu & Kashmir','Operational','GSM 900 / UMTS 2100',''),
	 (9466,404,64,'National','India','IN',99,'cellone','Chennai','Operational','GSM 900 / UMTS 2100',''),
	 (9467,404,66,'National','India','IN',99,'cellone','Maharashtra & Goa','Operational','GSM 900 / UMTS 2100',''),
	 (9468,404,67,'National','India','IN',99,'Reliance','Madhya Pradesh & Chhattisgarh','Operational','GSM 900 / UMTS 2100',''),
	 (9469,404,68,'National','India','IN',99,'DOLPHIN','Delhi & NCR','Operational','GSM 900 / UMTS 2100',''),
	 (9470,404,69,'National','India','IN',99,'DOLPHIN','Mumbai','Operational','GSM 900 / UMTS 2100',''),
	 (9471,404,70,'National','India','IN',99,'AirTel','Rajasthan','Operational','Unknown',''),
	 (9472,404,71,'National','India','IN',99,'cellone','Karnataka (Bangalore)','Operational','GSM 900 / UMTS 2100',''),
	 (9473,404,72,'National','India','IN',99,'cellone','Kerala','Operational','GSM 900 / UMTS 2100',''),
	 (9474,404,73,'National','India','IN',99,'cellone','Andhra Pradesh and Telangana','Operational','GSM 900 / UMTS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9475,404,74,'National','India','IN',99,'cellone','West Bengal','Operational','GSM 900 / UMTS 2100',''),
	 (9476,404,75,'National','India','IN',99,'cellone','Bihar','Operational','GSM 900 / UMTS 2100',''),
	 (9477,404,76,'National','India','IN',99,'cellone','Orissa','Operational','GSM 900 / UMTS 2100',''),
	 (9478,404,77,'National','India','IN',99,'cellone','North East','Operational','GSM 900 / UMTS 2100',''),
	 (9479,404,78,'National','India','IN',99,'IDEA','Madhya Pradesh & Chattishgarh','Operational','GSM 900 / UMTS 2100',''),
	 (9480,404,79,'National','India','IN',99,'cellone','Andaman Nicobar','Operational','GSM 900 / UMTS 2100',''),
	 (9481,404,80,'National','India','IN',99,'cellone','Tamil Nadu','Operational','GSM 900 / UMTS 2100',''),
	 (9482,404,81,'National','India','IN',99,'cellone','Kolkata','Operational','GSM 900 / UMTS 2100',''),
	 (9483,404,82,'National','India','IN',99,'IDEA','Himachal Pradesh','Operational','Unknown',''),
	 (9484,404,83,'National','India','IN',99,'Reliance','Kolkata','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9485,404,84,'National','India','IN',99,'Vodafone India','Chennai','Operational','GSM 1800',''),
	 (9486,404,85,'National','India','IN',99,'Reliance','West Bengal','Operational','GSM 1800',''),
	 (9487,404,86,'National','India','IN',99,'Vodafone India','Karnataka','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (9488,404,87,'National','India','IN',99,'IDEA','Rajasthan','Operational','Unknown',''),
	 (9489,404,88,'National','India','IN',99,'Vodafone India','Vodafone Punjab','Operational','Unknown',''),
	 (9490,404,89,'National','India','IN',99,'IDEA','Uttar Pradesh (East)','Operational','Unknown',''),
	 (9491,404,90,'National','India','IN',99,'AirTel','Maharashtra','Operational','GSM 1800',''),
	 (9492,404,91,'National','India','IN',99,'AIRCEL','Kolkata','Operational','GSM 900',''),
	 (9493,404,92,'National','India','IN',99,'AirTel','Mumbai','Operational','GSM 1800 / UMTS 2100',''),
	 (9494,404,93,'National','India','IN',99,'AirTel','Madhya Pradesh','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9495,404,94,'National','India','IN',99,'AirTel','Tamil Nadu','Operational','Unknown',''),
	 (9496,404,95,'National','India','IN',99,'AirTel','Kerala','Operational','GSM 1800',''),
	 (9497,404,96,'National','India','IN',99,'AirTel','Haryana','Operational','GSM 1800',''),
	 (9498,404,97,'National','India','IN',99,'AirTel','Uttar Pradesh (West)','Operational','Unknown',''),
	 (9499,404,98,'National','India','IN',99,'AirTel','Gujarat','Operational','Unknown',''),
	 (9500,405,1,'National','India','IN',99,'Reliance','Andhra Pradesh and Telangana','Operational','GSM 1800',''),
	 (9501,405,25,'National','India','IN',99,'TATA DOCOMO','Andhra Pradesh and Telangana','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9502,405,26,'National','India','IN',99,'TATA DOCOMO','Assam','Operational','CDMA 2000','EDGE, 2.5G'),
	 (9503,405,27,'National','India','IN',99,'TATA DOCOMO','Bihar/Jharkhand','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9504,405,28,'National','India','IN',99,'TATA DOCOMO','Chennai','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9505,405,29,'National','India','IN',99,'TATA DOCOMO','Delhi','Operational','CDMA 2000','EDGE, 2.75G'),
	 (9506,405,3,'National','India','IN',99,'Reliance','Bihar','Operational','GSM 1800',''),
	 (9507,405,30,'National','India','IN',99,'TATA DOCOMO','Gujarat','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9508,405,31,'National','India','IN',99,'TATA DOCOMO','Haryana','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9509,405,32,'National','India','IN',99,'TATA DOCOMO','Himachal Pradesh','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9510,405,33,'National','India','IN',99,'TATA DOCOMO','Jammu & Kashmir','Operational','CDMA 2000','EDGE, 2.75G'),
	 (9511,405,34,'National','India','IN',99,'TATA DOCOMO','Karnataka','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9512,405,35,'National','India','IN',99,'TATA DOCOMO','Kerala','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9513,405,36,'National','India','IN',99,'TATA DOCOMO','Kolkata','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9514,405,37,'National','India','IN',99,'TATA DOCOMO','Maharashtra & Goa','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9515,405,38,'National','India','IN',99,'TATA DOCOMO','Madhya Pradesh','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9516,405,39,'National','India','IN',99,'TATA DOCOMO','Mumbai','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9517,405,4,'National','India','IN',99,'Reliance','Chennai','Operational','GSM 1800',''),
	 (9518,405,41,'National','India','IN',99,'TATA DOCOMO','Orissa','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9519,405,42,'National','India','IN',99,'TATA DOCOMO','Punjab','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9520,405,43,'National','India','IN',99,'TATA DOCOMO','Rajasthan','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9521,405,44,'National','India','IN',99,'TATA DOCOMO','Tamil Nadu including Chennai','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9522,405,45,'National','India','IN',99,'TATA DOCOMO','Uttar Pradesh (E)','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G'),
	 (9523,405,46,'National','India','IN',99,'TATA DOCOMO','Uttar Pradesh (W) & Uttarakhand','Operational','CDMA 2000 / GSM 1800 / UMTS 2100','HSPA+, 3G network, EDGE, 2.75G'),
	 (9524,405,47,'National','India','IN',99,'TATA DOCOMO','West Bengal','Operational','CDMA 2000 / GSM 1800','EDGE, 2.75G');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9525,405,5,'National','India','IN',99,'Reliance','Delhi & NCR','Operational','GSM 1800',''),
	 (9526,405,6,'National','India','IN',99,'Reliance','Gujarat','Operational','GSM 1800',''),
	 (9527,405,7,'National','India','IN',99,'Reliance','Haryana','Operational','GSM',''),
	 (9528,405,8,'National','India','IN',99,'Reliance','Himachal Pradesh','Operational','GSM',''),
	 (9529,405,9,'National','India','IN',99,'Reliance','Jammu & Kashmir','Operational','GSM 1800 / UMTS 2100',''),
	 (9530,405,10,'National','India','IN',99,'Reliance','Karnataka','Operational','GSM',''),
	 (9531,405,11,'National','India','IN',99,'Reliance','Kerala','Operational','GSM',''),
	 (9532,405,12,'National','India','IN',99,'Reliance','Kolkata','Operational','GSM',''),
	 (9533,405,13,'National','India','IN',99,'Reliance','Maharashtra & Goa','Operational','GSM',''),
	 (9534,405,14,'National','India','IN',99,'Reliance','Madhya Pradesh','Operational','GSM','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9535,405,15,'National','India','IN',99,'Reliance','Mumbai','Operational','GSM 1800 / UMTS 2100',''),
	 (9536,405,17,'National','India','IN',99,'Reliance','Orissa','Operational','GSM',''),
	 (9537,405,18,'National','India','IN',99,'Reliance','Punjab','Operational','GSM',''),
	 (9538,405,19,'National','India','IN',99,'Reliance','Rajasthan','Operational','GSM',''),
	 (9539,405,20,'National','India','IN',99,'Reliance','Tamil Nadu','Operational','GSM',''),
	 (9540,405,21,'National','India','IN',99,'Reliance','Uttar Pradesh (East)','Operational','GSM',''),
	 (9541,405,22,'National','India','IN',99,'Reliance','Uttar Pradesh (West)','Operational','GSM',''),
	 (9542,405,23,'National','India','IN',99,'Reliance','West Bengal','Operational','GSM',''),
	 (9543,405,51,'National','India','IN',99,'AirTel','West Bengal','Operational','GSM 900',''),
	 (9544,405,52,'National','India','IN',99,'AirTel','Bihar & Jharkhand','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9545,405,53,'National','India','IN',99,'AirTel','Orissa','Operational','GSM',''),
	 (9546,405,54,'National','India','IN',99,'AirTel','Uttar Pradesh (East)','Operational','GSM 900',''),
	 (9547,405,55,'National','India','IN',99,'Airtel','Jammu & Kashmir','Operational','GSM 900 / UTMS 2100',''),
	 (9548,405,56,'National','India','IN',99,'AirTel','Assam','Operational','GSM 900 / GSM 1800',''),
	 (9549,405,66,'National','India','IN',99,'Vodafone India','Uttar Pradesh (West)','Operational','GSM 900 / GSM 1800',''),
	 (9550,405,67,'National','India','IN',99,'Vodafone India','West Bengal','Operational','Unknown',''),
	 (9551,405,70,'National','India','IN',99,'IDEA','Bihar & Jharkhand','Operational','GSM 1800',''),
	 (9552,405,750,'National','India','IN',99,'Vodafone India','Jammu & Kashmir','Operational','GSM 1800',''),
	 (9553,405,751,'National','India','IN',99,'Vodafone India','Assam','Operational','GSM 1800',''),
	 (9554,405,752,'National','India','IN',99,'Vodafone India','Bihar & Jharkhand','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9555,405,753,'National','India','IN',99,'Vodafone India','Orissa','Operational','GSM 1800',''),
	 (9556,405,754,'National','India','IN',99,'Vodafone India','Himachal Pradesh','Operational','GSM 1800',''),
	 (9557,405,755,'National','India','IN',99,'Vodafone India','North East','Operational','GSM 1800',''),
	 (9558,405,756,'National','India','IN',99,'Vodafone India','Madhya Pradesh & Chhattisgarh','Operational','GSM 1800',''),
	 (9559,405,799,'National','India','IN',99,'IDEA','Mumbai','Operational','GSM 900 / GSM 1800',''),
	 (9560,405,800,'National','India','IN',99,'AIRCEL','Delhi & NCR','Operational','GSM 1800',''),
	 (9561,405,801,'National','India','IN',99,'AIRCEL','Andhra Pradesh and Telangana','Operational','GSM 1800',''),
	 (9562,405,802,'National','India','IN',99,'AIRCEL','Gujarat','Not operational','GSM 1800',''),
	 (9563,405,803,'National','India','IN',99,'AIRCEL','Karnataka','Operational','GSM 1800',''),
	 (9564,405,804,'National','India','IN',99,'AIRCEL','Maharashtra & Goa','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9565,405,805,'National','India','IN',99,'AIRCEL','Mumbai','Operational','GSM 1800',''),
	 (9566,405,806,'National','India','IN',99,'AIRCEL','Rajasthan','Operational','GSM 1800',''),
	 (9567,405,807,'National','India','IN',99,'AIRCEL','Haryana','Not operational','GSM 1800',''),
	 (9568,405,808,'National','India','IN',99,'AIRCEL','Madhya Pradesh','Not operational','GSM 1800',''),
	 (9569,405,809,'National','India','IN',99,'AIRCEL','Kerala','Operational','GSM 1800',''),
	 (9570,405,810,'National','India','IN',99,'AIRCEL','Uttar Pradesh (East)','Operational','GSM 1800',''),
	 (9571,405,811,'National','India','IN',99,'AIRCEL','Uttar Pradesh (West)','Operational','GSM',''),
	 (9572,405,812,'National','India','IN',99,'AIRCEL','Punjab','Not operational','GSM','License cancelled by Supreme Court'),
	 (9573,405,819,'National','India','IN',99,'Uninor','Andhra Pradesh and Telangana','Operational','GSM',''),
	 (9574,405,818,'National','India','IN',99,'Uninor','Uttar Pradesh (West)','Operational','GSM','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9575,405,820,'National','India','IN',99,'Uninor','Karnataka','Operational','GSM 1800',''),
	 (9576,405,821,'National','India','IN',99,'Uninor','Kerala','Operational','GSM 1800',''),
	 (9577,405,822,'National','India','IN',99,'Uninor','Kolkata','Operational','GSM',''),
	 (9578,405,824,'National','India','IN',99,'Videocon Datacom','Assam','Reserved','GSM 1800',''),
	 (9579,405,827,'National','India','IN',99,'Videocon Datacom','Gujarat','Operational','GSM 1800',''),
	 (9580,405,834,'National','India','IN',99,'Videocon Datacom','Madhya Pradesh','Reserved','GSM 1800',''),
	 (9581,405,844,'National','India','IN',99,'Uninor','Delhi & NCR','Not operational','GSM',''),
	 (9582,405,840,'National','India','IN',99,'Jio','West Bengal','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9583,405,845,'National','India','IN',99,'IDEA','Assam','Operational','GSM 1800',''),
	 (9584,405,846,'National','India','IN',99,'IDEA','Jammu & Kashmir','Operational','GSM 1800 / UTMS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9585,405,847,'National','India','IN',99,'IDEA','Karnataka','Operational','GSM 1800',''),
	 (9586,405,848,'National','India','IN',99,'IDEA','Kolkata','Operational','GSM 1800',''),
	 (9587,405,849,'National','India','IN',99,'IDEA','North East','Operational','GSM 1800',''),
	 (9588,405,850,'National','India','IN',99,'IDEA','Orissa','Operational','GSM 1800',''),
	 (9589,405,851,'National','India','IN',99,'IDEA','Punjab','Operational','GSM 1800',''),
	 (9590,405,852,'National','India','IN',99,'IDEA','Tamil Nadu','Operational','GSM 1800',''),
	 (9591,405,853,'National','India','IN',99,'IDEA','West Bengal','Operational','GSM 1800',''),
	 (9592,405,854,'National','India','IN',99,'Jio','Andhra Pradesh','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9593,405,855,'National','India','IN',99,'Jio','Assam','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9594,405,856,'National','India','IN',99,'Jio','Bihar','Operational','LTE 850 / LTE 1800 / TD-LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9595,405,857,'National','India','IN',99,'Jio','Gujarat','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9596,405,858,'National','India','IN',99,'Jio','Haryana','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9597,405,859,'National','India','IN',99,'Jio','Himachal Pradesh','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9598,405,860,'National','India','IN',99,'Jio','Jammu & Kashmir','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9599,405,861,'National','India','IN',99,'Jio','Karnataka','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9600,405,862,'National','India','IN',99,'Jio','Kerala','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9601,405,863,'National','India','IN',99,'Jio','Madhya Pradesh','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9602,405,864,'National','India','IN',99,'Jio','Maharashtra','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9603,405,865,'National','India','IN',99,'Jio','North East','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9604,405,866,'National','India','IN',99,'Jio','Orissa','Operational','LTE 850 / LTE 1800 / TD-LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9605,405,867,'National','India','IN',99,'Jio','Punjab','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9606,405,868,'National','India','IN',99,'Jio','Rajasthan','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9607,405,869,'National','India','IN',99,'Jio','Tamil Nadu (incl. Chennai)','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9608,405,870,'National','India','IN',99,'Jio','Uttar Pradesh (West)','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9609,405,871,'National','India','IN',99,'Jio','Uttar Pradesh (East)','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9610,405,872,'National','India','IN',99,'Jio','Delhi','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9611,405,873,'National','India','IN',99,'Jio','Kolkata','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9612,405,874,'National','India','IN',99,'Jio','Mumbai','Operational','LTE 850 / LTE 1800 / TD-LTE 2300',''),
	 (9613,405,875,'National','India','IN',99,'Uninor','Assam','Reserved','GSM 1800',''),
	 (9614,405,880,'National','India','IN',99,'Uninor','West Bengal','Operational','GSM 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9615,405,881,'National','India','IN',99,'S Tel','Assam','Reserved','GSM 1800',''),
	 (9616,405,908,'National','India','IN',99,'IDEA','Andhra Pradesh and Telangana','Operational','GSM 1800',''),
	 (9617,405,909,'National','India','IN',99,'IDEA','Delhi','Operational','GSM 1800',''),
	 (9618,405,910,'National','India','IN',99,'IDEA','Haryana','Operational','GSM 1800',''),
	 (9619,405,911,'National','India','IN',99,'IDEA','Maharashtra','Operational','GSM 1800',''),
	 (9620,405,912,'National','India','IN',99,'Etisalat DB(cheers)','Andhra Pradesh and Telangana','Not operational','GSM 1800','License cancelled by Supreme Court'),
	 (9621,405,913,'National','India','IN',99,'Etisalat DB(cheers)','Delhi & NCR','Not operational','GSM 1800','License cancelled by Supreme Court'),
	 (9622,405,914,'National','India','IN',99,'Etisalat DB(cheers)','Gujarat','Not operational','GSM 1800','License cancelled by Supreme Court'),
	 (9623,405,917,'National','India','IN',99,'Etisalat DB(cheers)','Kerala','Not operational','GSM 1800','License cancelled by Supreme Court'),
	 (9624,405,927,'National','India','IN',99,'Uninor','Gujarat','Operational','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9625,405,929,'National','India','IN',99,'Uninor','Maharashtra','Operational','GSM 1800',''),
	 (9626,510,0,'National','Indonesia','ID',100,'PSN','PT Pasifik Satelit Nusantara (ACeS)','Operational','Satellite',''),
	 (9627,510,1,'National','Indonesia','ID',100,'Indosat Ooredoo','PT Indonesian Satellite Corporation Tbk (INDOSAT)','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800','Former PT Satelindo'),
	 (9628,510,3,'National','Indonesia','ID',100,'StarOne','PT Indosat Tbk','Not operational','CDMA 800','Shut down on 30 June 2015'),
	 (9629,510,7,'National','Indonesia','ID',100,'TelkomFlexi','PT Telkom','Not operational','CDMA 800','Network shut down end of 2015'),
	 (9630,510,8,'National','Indonesia','ID',100,'AXIS','PT Natrindo Telepon Seluler','Not operational','GSM 1800 / UMTS 2100','Merged with XL (MNC 11), MNC 08 no longer used'),
	 (9631,510,9,'National','Indonesia','ID',100,'Smartfren','PT Smartfren Telecom','Operational','LTE 850 / TD-LTE 2300','CDMA 1900 shut down December 2016, CDMA 850 shut down November 2017'),
	 (9632,510,10,'National','Indonesia','ID',100,'Telkomsel','PT Telekomunikasi Selular','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800 / TD-LTE 2300',''),
	 (9633,510,11,'National','Indonesia','ID',100,'XL','PT XL Axiata Tbk','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800',''),
	 (9634,510,20,'National','Indonesia','ID',100,'TELKOMMobile','PT Telkom Indonesia Tbk','Not operational','GSM 1800','Merged with Telkomsel');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9635,510,21,'National','Indonesia','ID',100,'IM3','PT Indonesian Satellite Corporation Tbk (INDOSAT)','Not operational','GSM 1800','Merged with Indosat (MNC 01), MNC 21 no longer used'),
	 (9636,510,27,'National','Indonesia','ID',100,'Net1','PT Sampoerna Telekomunikasi Indonesia','Operational','CDMA 450 / LTE 450','Former Ceria'),
	 (9637,510,28,'National','Indonesia','ID',100,'Fren/Hepi','PT Mobile-8 Telecom','Operational','LTE 850 / TD-LTE 2300','Merged with SMART (MNC 09), CDMA 850 shut down November 2017'),
	 (9638,510,88,'National','Indonesia','ID',100,'BOLT! Super 4G','PT Internux','Operational','TD-LTE 2300','Jabodetabek & Medan Area only'),
	 (9639,510,89,'National','Indonesia','ID',100,'3','PT Hutchison CP Telecommunications','Operational','GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9640,510,99,'National','Indonesia','ID',100,'Esia','PT Bakrie Telecom','Not operational','CDMA 800','Merged with Smartfren (MNC 09)'),
	 (9641,432,8,'National','Iran','IR',101,'Shatel','Shatel Mobile','Operational','MVNO',''),
	 (9642,432,11,'National','Iran','IR',101,'IR-MCI (Hamrah-e-Avval)','Mobile Communications Company of Iran','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (9643,432,12,'National','Iran','IR',101,'Avacell(HiWEB)','Dadeh Dostar asr Novin p.j.s. co & Information Technology Company of Iran','Operational','LTE 800','Mostly used in rural areas with poor telephone line and cable equipments'),
	 (9644,432,14,'National','Iran','IR',101,'TKC','Telecommunication Kish Company','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9645,432,19,'National','Iran','IR',101,'MTCE (Espadan)','Mobile Telecommunications Company of Esfahan','Not operational','GSM 900',''),
	 (9646,432,20,'National','Iran','IR',101,'Rightel','Social Security Investment Co.','Operational','UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (9647,432,32,'National','Iran','IR',101,'Taliya','TCI of Iran and Iran Mobin','Not operational','GSM 900 / GSM 1800','Roaming On MCI'),
	 (9648,432,35,'National','Iran','IR',101,'MTN Irancell','MTN Irancell Telecommunications Services Company','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600 / TD-LTE 3500',''),
	 (9649,432,40,'National','Iran','IR',101,'Mobinnet','Ertebatat Mobinnet','Operational','LTE 3500',''),
	 (9650,432,50,'National','Iran','IR',101,'Shatel','Arya Resaneh Tadbir','Operational','MVNO',''),
	 (9651,432,70,'National','Iran','IR',101,'TCI','Telephone Communications Company of Iran','Operational','GSM 900','Mostly used in rural areas with poor telephone lines and cable equipment, instead of telephone (WLL)'),
	 (9652,432,93,'National','Iran','IR',101,'Iraphone','Iraphone','Not operational','GSM 1800','Mostly used in rural areas with poor telephone line and cable equipments, instead of telephone'),
	 (9653,418,0,'National','Iraq','IQ',102,'Asia Cell','Asia Cell Telecommunications Company','Operational','GSM 900',''),
	 (9654,418,5,'National','Iraq','IQ',102,'Asia Cell','Asia Cell Telecommunications Company','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9655,418,8,'National','Iraq','IQ',102,'SanaTel','','Operational','GSM 900',''),
	 (9656,418,20,'National','Iraq','IQ',102,'Zain','Zain Iraq','Operational','GSM 900 / GSM 1800','Former MTC Atheer'),
	 (9657,418,30,'National','Iraq','IQ',102,'Zain','Zain Iraq','Operational','GSM 900','Former Orascom Telecom (Iraqna)'),
	 (9658,418,40,'National','Iraq','IQ',102,'Korek','Telecom Ltd','Operational','GSM 900',''),
	 (9659,418,45,'National','Iraq','IQ',102,'Mobitel','Mobitel Co. Ltd.','Operational','UMTS',''),
	 (9660,418,62,'National','Iraq','IQ',102,'Itisaluna','Itisaluna Wireless CO.','Operational','CDMA 800 / CDMA 1900',''),
	 (9661,418,92,'National','Iraq','IQ',102,'Omnnea','Omnnea Wireless','Operational','CDMA',''),
	 (9662,272,1,'National','Ireland','IE',103,'Vodafone','Vodafone Ireland','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9663,272,2,'National','Ireland','IE',103,'3','Hutchison 3G Ireland limited','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Telefonica O2'),
	 (9664,272,3,'National','Ireland','IE',103,'Eir','Eir Group plc','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Former Meteor');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9665,272,4,'National','Ireland','IE',103,'','Access Telecom','Unknown','Unknown',''),
	 (9666,272,5,'National','Ireland','IE',103,'3','Hutchison 3G Ireland limited','Operational','UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9667,272,7,'National','Ireland','IE',103,'Eir','Eir Group plc','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former eMobile'),
	 (9668,272,8,'National','Ireland','IE',103,'Eir','Eir Group plc','Unknown','Unknown',''),
	 (9669,272,9,'National','Ireland','IE',103,'','Clever Communications Ltd.','Not operational','Unknown','MNC withdrawn'),
	 (9670,272,11,'National','Ireland','IE',103,'Tesco Mobile','Liffey Telecom','Operational','MVNO','Uses 3'),
	 (9671,272,13,'National','Ireland','IE',103,'Lycamobile','Lycamobile','Operational','MVNO','Uses 3'),
	 (9672,272,15,'National','Ireland','IE',103,'Virgin Mobile','UPC','Operational','MVNO','Former upc'),
	 (9673,272,16,'National','Ireland','IE',103,'Carphone Warehouse','Carphone Warehouse','Operational','MVNO',''),
	 (9674,272,17,'National','Ireland','IE',103,'3','Hutchison 3G Ireland limited','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9675,234,18,'National','Isle of Man (United Kingdom)','IM',247,'Cloud 9 Mobile','Cloud 9 Mobile Communications PLC','Not operational','GSM 1800 / UMTS 2100','Retired'),
	 (9676,234,36,'National','Isle of Man (United Kingdom)','IM',247,'Sure Mobile','Sure Isle of Man Ltd.','Operational','GSM 900 / GSM 1800 / LTE','Former Cable & Wireless'),
	 (9677,234,58,'National','Isle of Man (United Kingdom)','IM',247,'Pronto GSM','Manx Telecom','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9678,425,1,'National','Israel','IL',104,'Partner','Partner Communications Company Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800','Former Orange (until 2016)'),
	 (9679,425,2,'National','Israel','IL',104,'Cellcom','Cellcom Israel Ltd.','Operational','GSM 1800 / UMTS 850 / UMTS 2100 / LTE 1800',''),
	 (9680,425,3,'National','Israel','IL',104,'Pelephone','Pelephone Communications Ltd.','Operational','UMTS 850 / UMTS 2100 / LTE 1800','CDMA 850 shut down July 2017'),
	 (9681,425,4,'National','Israel','IL',104,'','Globalsim Ltd','Unknown','Unknown',''),
	 (9682,425,5,'National','Israel','IL',104,'Jawwal','Palestine Cellular Communications Ltd.','Operational','GSM 900','Covering the Palestinian territories'),
	 (9683,425,6,'National','Israel','IL',104,'Wataniya Mobile','Wataniya Palestine Ltd. (Ooredoo)','Operational','GSM 900 / GSM 1800','Covering the Palestinian territories'),
	 (9684,425,7,'National','Israel','IL',104,'Hot Mobile','Hot Mobile Ltd.','Operational','iDEN 800 / UMTS 2100','Former Mirs Communications; uses Pelephone network for roaming');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9685,425,8,'National','Israel','IL',104,'Golan Telecom','Golan Telecom Ltd','Operational','UMTS 2100 / LTE 1800','Uses Cellcom network for roaming'),
	 (9686,425,9,'National','Israel','IL',104,'018 Xphone','Marathon 018 Xphone Ltd.','Operational','LTE 1800',''),
	 (9687,425,11,'National','Israel','IL',104,'','365 Telecom','Unknown','MVNO',''),
	 (9688,425,12,'National','Israel','IL',104,'','Free Telecom','Unknown','MVNO',''),
	 (9689,425,13,'National','Israel','IL',104,'','Ituran Cellular Communications','Unknown','Unknown',''),
	 (9690,425,14,'National','Israel','IL',104,'Youphone','Alon Cellular Ltd.','Operational','MVNO','MVNO (Partner)'),
	 (9691,425,15,'National','Israel','IL',104,'Home Cellular','Home Cellular','Operational','MVNO','MVNO (Cellcom)'),
	 (9692,425,16,'National','Israel','IL',104,'Rami Levy','Rami Levy Communications Ltd.','Operational','MVNO','MVNO (Pelephone)'),
	 (9693,425,17,'National','Israel','IL',104,'Sipme','Gale Phone','Unknown','MVNO',''),
	 (9694,425,18,'National','Israel','IL',104,'Cellact Communications','Cellact Communications Ltd.','Operational','MVNO','MVNO (Pelephone)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9695,425,19,'National','Israel','IL',104,'Telzar 019','Azi Communications Ltd.','Operational','MVNO',''),
	 (9696,425,20,'National','Israel','IL',104,'Bezeq','Bezeq The Israeli Telecommunication Corp Ltd.','Unknown','Unknown',''),
	 (9697,425,21,'National','Israel','IL',104,'Bezeq International','B.I.P. Communications Ltd.','Unknown','Unknown',''),
	 (9698,425,23,'National','Israel','IL',104,'','Beezz Communication Solutions Ltd.','Unknown','Unknown',''),
	 (9699,425,24,'National','Israel','IL',104,'012 Telecom','Partner Communications Company Ltd.','Operational','MVNO','MVNO (Partner)'),
	 (9700,425,25,'National','Israel','IL',104,'IMOD','Israel Ministry of Defense','Not operational','LTE','launching in 2016'),
	 (9701,425,26,'National','Israel','IL',104,'','LB Annatel Ltd.','Operational','MVNO',''),
	 (9702,425,28,'National','Israel','IL',104,'','PHI Networks','Unknown','LTE 1800','Joint venture between Partner Communications Company and Hot Mobile'),
	 (9703,425,29,'National','Israel','IL',104,'','CG Networks','Unknown','Unknown',''),
	 (9704,222,1,'National','Italy','IT',105,'TIM','Telecom Italia S.p.A','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1500 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9705,222,2,'National','Italy','IT',105,'Elsacom','','Not operational','Satellite (Globalstar)','Retired'),
	 (9706,222,4,'National','Italy','IT',105,'Intermatica','','Unknown','Unknown',''),
	 (9707,222,5,'National','Italy','IT',105,'Telespazio','','Unknown','Unknown',''),
	 (9708,222,6,'National','Italy','IT',105,'Vodafone','Vodafone Italia S.p.A.','Unknown','Unknown',''),
	 (9709,222,7,'National','Italy','IT',105,'Nòverca','Nòverca Italia','Not operational','MVNO','MVNO operation shut down May 2015'),
	 (9710,222,8,'National','Italy','IT',105,'Fastweb','Fastweb S.p.A.','Operational','MVNO',''),
	 (9711,222,10,'National','Italy','IT',105,'Vodafone','Vodafone Italia S.p.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1500 / LTE 1800 / LTE 2600',''),
	 (9712,222,30,'National','Italy','IT',105,'RFI','Rete Ferroviaria Italiana','Operational','GSM-R 900','railways communication'),
	 (9713,222,33,'National','Italy','IT',105,'Poste Mobile','Poste Mobile S.p.A.','Operational','MVNO','uses Vodafone and Wind Network'),
	 (9714,222,34,'National','Italy','IT',105,'BT Italia','British Telecom Italia','Reserved','MVNO','uses TIM Network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9715,222,35,'National','Italy','IT',105,'Lycamobile','Lycamobile','Operational','MVNO','uses Vodafone Network'),
	 (9716,222,36,'National','Italy','IT',105,'Digi Mobil','Digi Italy S.r.l.','Unknown','Unknown','uses TIM Network'),
	 (9717,222,37,'National','Italy','IT',105,'3 Italia','H3G S.p.A.','Unknown','Unknown',''),
	 (9718,222,38,'National','Italy','IT',105,'LINKEM','Linkem S.p.A.','Operational','TD-LTE 3500',''),
	 (9719,222,39,'National','Italy','IT',105,'SMS Italia','SMS Italia S.r.l.','Unknown','Unknown',''),
	 (9720,222,43,'National','Italy','IT',105,'TIM','Telecom Italia S.p.A.','Unknown','Unknown',''),
	 (9721,222,48,'National','Italy','IT',105,'TIM','Telecom Italia S.p.A.','Unknown','Unknown',''),
	 (9722,222,50,'National','Italy','IT',105,'Ho','Iliad Italia','Not operational','900 / 1800 / 2100 / 2600','Planned launch in 2017'),
	 (9723,222,77,'National','Italy','IT',105,'IPSE 2000','','Not operational','UMTS 2100','Retired'),
	 (9724,222,88,'National','Italy','IT',105,'Wind','Wind Telecomunicazioni S.p.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9725,222,98,'National','Italy','IT',105,'BLU','BLU S.p.A.','Not operational','GSM 900',''),
	 (9726,222,99,'National','Italy','IT',105,'3 Italia','H3G S.p.A.','Operational','UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (9727,612,1,'National','Ivory Coast','CI',53,'','Cora de Comstar','Not operational','Unknown',''),
	 (9728,612,2,'National','Ivory Coast','CI',53,'Moov','Atlantique Cellulaire','Operational','GSM 900 / GSM 1800 / UMTS / LTE 2600',''),
	 (9729,612,3,'National','Ivory Coast','CI',53,'Orange','Orange','Operational','GSM 900 / UMTS / LTE 1800',''),
	 (9730,612,4,'National','Ivory Coast','CI',53,'KoZ','Comium Ivory Coast Inc','Operational','GSM 900 / GSM 1800',''),
	 (9731,612,5,'National','Ivory Coast','CI',53,'MTN','Loteny Telecom','Operational','GSM 900 / UMTS / LTE 800',''),
	 (9732,612,6,'National','Ivory Coast','CI',53,'GreenN','Oricel','Operational','GSM 1800',''),
	 (9733,612,7,'National','Ivory Coast','CI',53,'café','Aircomm','Operational','GSM 1800',''),
	 (9734,612,18,'National','Ivory Coast','CI',53,'','YooMee','Operational','TD-LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9735,338,20,'National','Jamaica','JM',106,'FLOW','LIME (Cable & Wireless)','Not operational','Unknown','MNC withdrawn'),
	 (9736,338,40,'National','Jamaica','JM',106,'Caricel','Symbiote Investment Limited','Unknown','LTE',''),
	 (9737,338,50,'National','Jamaica','JM',106,'Digicel','Digicel (Jamaica) Limited','Operational','GSM 900 / GSM 1800 / UMTS 850 / LTE 700 / CDMA 1900',''),
	 (9738,338,70,'National','Jamaica','JM',106,'Claro','Oceanic Digital Jamaica Limited','Not operational','GSM / UMTS / CDMA','shut down 2012'),
	 (9739,338,110,'National','Jamaica','JM',106,'FLOW','Cable & Wireless Communications','Operational','Unknown',''),
	 (9740,338,180,'National','Jamaica','JM',106,'FLOW','Cable & Wireless Communications','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 1700',''),
	 (9741,440,0,'National','Japan','JP',107,'Y!Mobile','SoftBank Corp.','Operational','UMTS 1800','band 9'),
	 (9742,440,1,'National','Japan','JP',107,'UQ WiMAX','UQ Communications Inc.','Operational','WiMAX 2500 / TD-LTE 2500','LTE band 41'),
	 (9743,440,2,'National','Japan','JP',107,'','Hanshin Cable Engineering Co., Ltd.','Unknown','WiMAX 2500',''),
	 (9744,440,3,'National','Japan','JP',107,'IIJmio','Internet Initiative Japan Inc.','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9745,440,4,'National','Japan','JP',107,'','Japan Radio Company, Ltd.','Unknown','Unknown',''),
	 (9746,440,5,'National','Japan','JP',107,'','Wireless City Planning Inc.','Operational','TD-LTE 2500','band 41; owned by SoftBank'),
	 (9747,440,6,'National','Japan','JP',107,'','SAKURA Internet Inc.','Unknown','Unknown',''),
	 (9748,440,7,'National','Japan','JP',107,'','LTE-X, Inc.','Unknown','MVNO',''),
	 (9749,440,10,'National','Japan','JP',107,'NTT docomo','NTT DoCoMo, Inc.','Operational','UMTS 850 / UMTS 1800 / UMTS 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 1800 / LTE 2100 / TD-LTE 3500','bands 1, 9, 19, 21, 28, 42'),
	 (9750,440,20,'National','Japan','JP',107,'SoftBank','SoftBank Corp.','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 900 / LTE 1500 / LTE 1800 / LTE 2100 / TD-LTE 3500','bands 1, 8, 9, 11, 28, 42'),
	 (9751,440,21,'National','Japan','JP',107,'SoftBank','SoftBank Corp.','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 900 / LTE 1500 / LTE 1800 / LTE 2100 / TD-LTE 3500','bands 1, 8, 9, 11, 28, 42'),
	 (9752,440,50,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9753,440,51,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9754,440,52,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9755,440,53,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9756,440,54,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9757,440,70,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9758,440,71,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9759,440,72,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9760,440,73,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9761,440,74,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9762,440,75,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9763,440,76,'National','Japan','JP',107,'au','KDDI Corporation','Operational','CDMA2000 850 / CDMA2000 2100 / LTE 700 / LTE 850 / LTE 1500 / LTE 2100 / TD-LTE 3500','bands 1, 11, 26 (18), 28, 42'),
	 (9764,440,78,'National','Japan','JP',107,'au','Okinawa Cellular Telephone','Operational','CDMA2000 850 / CDMA2000 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9765,440,91,'National','Japan','JP',107,'','Tokyo Organising Committee of the Olympic and Paralympic Games','Unknown','Unknown',''),
	 (9766,441,0,'National','Japan','JP',107,'','Wireless City Planning Inc.','Operational','TD-LTE 2500','band 41; owned by SoftBank'),
	 (9767,441,1,'National','Japan','JP',107,'SoftBank','SoftBank Corp.','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 900 / LTE 1500 / LTE 1800 / LTE 2100 / TD-LTE 3500','bands 1, 8, 9, 11, 28, 42'),
	 (9768,441,10,'National','Japan','JP',107,'UQ WiMAX','UQ Communications Inc.','Operational','WiMAX 2500 / TD-LTE 2500','LTE band 41'),
	 (9769,234,3,'National','Jersey (United Kingdom)','JE',248,'Airtel-Vodafone','Jersey Airtel Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9770,234,28,'National','Jersey (United Kingdom)','JE',248,'','Marathon Telecom Limited','Not operational','UMTS 2100','holds license but not network built'),
	 (9771,234,50,'National','Jersey (United Kingdom)','JE',248,'JT','JT Group Limited','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9772,234,55,'National','Jersey (United Kingdom)','JE',248,'Sure Mobile','Sure (Jersey) Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','former Cable & Wireless'),
	 (9773,416,1,'National','Jordan','JO',108,'zain JO','Jordan Mobile Telephone Services','Operational','GSM 900 / LTE 1800','Former Fastlink'),
	 (9774,416,2,'National','Jordan','JO',108,'XPress Telecom','XPress Telecom','Not operational','iDEN 800','Shut down in 2010');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9775,416,3,'National','Jordan','JO',108,'Umniah','Umniah Mobile Company','Operational','GSM 1800 / LTE 1800 / LTE 3500',''),
	 (9776,416,77,'National','Jordan','JO',108,'Orange','Petra Jordanian Mobile Telecommunications Company (MobileCom)','Operational','GSM 900 / LTE 1800',''),
	 (9777,401,1,'National','Kazakhstan','KZ',109,'Beeline','KaR-Tel LLP','Operational','GSM 900 / GSM 1800 / LTE 800 / LTE 1800 / LTE 2100',''),
	 (9778,401,2,'National','Kazakhstan','KZ',109,'Kcell','Kcell JSC','Operational','GSM 900 / GSM 1800 / LTE 800 / LTE 1800',''),
	 (9779,401,7,'National','Kazakhstan','KZ',109,'Altel','Altel','Operational','UMTS 850 / GSM 1800 / LTE 1800','CDMA2000 800 closed 1 July 2015; acquired by Tele2'),
	 (9780,401,8,'National','Kazakhstan','KZ',109,'Kazakhtelecom','','Operational','CDMA2000 800 / CDMA2000 450',''),
	 (9781,401,77,'National','Kazakhstan','KZ',109,'Tele2.kz','MTS','Operational','GSM 900 / GSM 1800 / UMTS 900','Called Mobile Telecom Service before its acquisition by Tele2'),
	 (9782,639,1,'National','Kenya','KE',110,'Safaricom','Safaricom Limited','Unknown','Unknown',''),
	 (9783,639,2,'National','Kenya','KE',110,'Safaricom','Safaricom Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9784,639,3,'National','Kenya','KE',110,'Airtel','Bharti Airtel','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800','Former Celtel, then Zain');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9785,639,4,'National','Kenya','KE',110,'','Mobile Pay Kenya Limited','Unknown','Unknown',''),
	 (9786,639,5,'National','Kenya','KE',110,'yu','Essar Telecom Kenya','Not operational','GSM 900','Former Econet Wireless; network sold to Safaricom in 2014, subscribers moved to Airtel'),
	 (9787,639,6,'National','Kenya','KE',110,'','Finserve Africa Limited','Unknown','Unknown',''),
	 (9788,639,7,'National','Kenya','KE',110,'Telkom','Telkom Kenya','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','Former Orange Kenya; CDMA 850 MHz shut down in Mar 2015'),
	 (9789,639,8,'National','Kenya','KE',110,'','Sema Mobile Services Limited','Operational','MVNO','Uses Airtel'),
	 (9790,639,9,'National','Kenya','KE',110,'','Homeland Media Group Limited','Unknown','Unknown',''),
	 (9791,639,10,'National','Kenya','KE',110,'Faiba 4G','Jamii Telecommunications Limited','Operational','LTE 700','LTE band 28'),
	 (9792,639,11,'National','Kenya','KE',110,'','WiAfrica Kenya Limited','Unknown','Unknown',''),
	 (9793,545,1,'National','Kiribati','KI',111,'Kiribati - TSKL','Telecom Services Kiribati Ltd','Operational','UMTS 850 / LTE 700','Acquired by Amalgamated Telecom Holdings (ATHKL) in May 2015'),
	 (9794,545,2,'National','Kiribati','KI',111,'','OceanLink','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9795,545,9,'National','Kiribati','KI',111,'Kiribati - Frigate Net','Telecom Services Kiribati Ltd','Operational','GSM 900','Acquired by Amalgamated Telecom Holdings (ATHKL) in May 2015'),
	 (9796,467,5,'National','North Korea','KP',112,'Koryolink','Cheo Technology Jv Company','Operational','UMTS 2100','for foreigners'),
	 (9797,467,6,'National','North Korea','KP',112,'Koryolink','Cheo Technology Jv Company','Operational','UMTS 2100','for DPRK citizens'),
	 (9798,467,193,'National','North Korea','KP',112,'SunNet','Korea Posts and Telecommunications Corporation','Not operational','GSM 900',''),
	 (9799,450,1,'National','South Korea','KR',113,'','Globalstar Asia Pacific','Operational','Satellite',''),
	 (9800,450,2,'National','South Korea','KR',113,'KT','KT','Unknown','5G','Test network; former Hansol PCS (CDMA2000 1800), Merged with KT in 2002'),
	 (9801,450,3,'National','South Korea','KR',113,'Power 017','Shinsegi Telecom, Inc.','Not operational','CDMA2000 800','Merged with SK Telecom in 2002; MNC withdrawn'),
	 (9802,450,4,'National','South Korea','KR',113,'KT','KT','Unknown','Unknown','IoT network; former CDMA2000 1800'),
	 (9803,450,5,'National','South Korea','KR',113,'SKTelecom','SK Telecom','Operational','CDMA2000 800 / UMTS 2100 / LTE 850 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (9804,450,6,'National','South Korea','KR',113,'LG U+','LG Telecom','Operational','CDMA2000 1800 / LTE 850 / LTE 2100 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9805,450,7,'National','South Korea','KR',113,'KT','KT','Unknown','Unknown',''),
	 (9806,450,8,'National','South Korea','KR',113,'olleh','KT','Operational','UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100',''),
	 (9807,450,11,'National','South Korea','KR',113,'','Korea Cable Telecom','Operational','MVNO','MVNO of SK Telecom'),
	 (9808,450,12,'National','South Korea','KR',113,'SKTelecom','SK Telecom','Unknown','Unknown','IoT network'),
	 (9809,221,1,'National','Kosovo','XK',249,'Vala','Telecom of Kosovo J.S.C.','Operational','GSM 900 / LTE 1800','Previously the Monaco MCC/MNC 212-01 was used.'),
	 (9810,221,2,'National','Kosovo','XK',249,'IPKO','IPKO','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Previously the Slovenian MCC/MNC 293-41 was used. Used by MVNO D3 Mobile.'),
	 (9811,221,6,'National','Kosovo','XK',249,'Z Mobile','Dardaphone.Net LLC','Operational','MVNO','Previously the Monaco MCC/MNC 212-01 was used.'),
	 (9812,419,2,'National','Kuwait','KW',114,'zain KW','Zain Kuwait','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (9813,419,3,'National','Kuwait','KW',114,'K.S.C Ooredoo','National Mobile Telecommunications','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9814,419,4,'National','Kuwait','KW',114,'Viva','Kuwait Telecommunication Company','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9815,437,1,'National','Kyrgyzstan','KG',115,'Beeline','Sky Mobile LLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','former Bitel'),
	 (9816,437,3,'National','Kyrgyzstan','KG',115,'Fonex','Aktel Ltd','Not operational','CDMA2000 850','Shut down on 7 May 2016'),
	 (9817,437,5,'National','Kyrgyzstan','KG',115,'MegaCom','Alfa Telecom CJSC','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100',''),
	 (9818,437,9,'National','Kyrgyzstan','KG',115,'O!','NurTelecom LLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 2600',''),
	 (9819,457,1,'National','Laos','LA',116,'LaoTel','Lao Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600',''),
	 (9820,457,2,'National','Laos','LA',116,'ETL','Enterprise of Telecommunications Lao','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9821,457,3,'National','Laos','LA',116,'Unitel','Star Telecom Co., Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE','Former Lao-Asia Telecom Company (LAT); owned by Viettel'),
	 (9822,457,8,'National','Laos','LA',116,'Beeline','VimpelCom Lao Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Millicom Lao Co Ltd (Tigo)'),
	 (9823,247,1,'National','Latvia','LV',117,'LMT','Latvian Mobile Telephone','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (9824,247,2,'National','Latvia','LV',117,'Tele2','Tele2','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9825,247,3,'National','Latvia','LV',117,'TRIATEL','Telekom Baltija','Operational','CDMA 450',''),
	 (9826,247,4,'National','Latvia','LV',117,'','Beta Telecom','Not operational','Unknown','Former Lattelecom; MNC withdrawn'),
	 (9827,247,5,'National','Latvia','LV',117,'Bite','Bite Latvija','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Bite''s postpaid customers are still being assigned SIM cards with 246 02 MNC'),
	 (9828,247,6,'National','Latvia','LV',117,'','Rigatta','Not operational','Unknown','MNC withdrawn'),
	 (9829,247,7,'National','Latvia','LV',117,'','SIA \"MEGATEL\"','Operational','MVNO','Uses Bite network; former Master Telecom'),
	 (9830,247,8,'National','Latvia','LV',117,'IZZI','IZZI','Not operational','MVNO','MNC withdrawn'),
	 (9831,247,9,'National','Latvia','LV',117,'Xomobile','Camel Mobile','Operational','MVNO','Former Global Mobile Solutions'),
	 (9832,415,1,'National','Lebanon','LB',118,'Alfa','MIC 1','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (9833,415,3,'National','Lebanon','LB',118,'Touch','MIC 2','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9834,415,5,'National','Lebanon','LB',118,'Ogero Mobile','Ogero Telecom','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9835,651,1,'National','Lesotho','LS',119,'Vodacom','Vodacom Lesotho (Pty) Ltd','Operational','GSM 900 / LTE 800',''),
	 (9836,651,2,'National','Lesotho','LS',119,'Econet Telecom','Econet Ezi-cel','Operational','GSM / UMTS',''),
	 (9837,618,1,'National','Liberia','LR',120,'Lonestar Cell','Lonestar Communications Corporation','Operational','GSM 900',''),
	 (9838,618,2,'National','Liberia','LR',120,'Libercell','Atlantic Wireless (Liberia) Inc.','Not operational','Unknown','Shut down in 2012'),
	 (9839,618,4,'National','Liberia','LR',120,'Novafone','Novafone Inc.','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Comium'),
	 (9840,618,7,'National','Liberia','LR',120,'Orange LBR','Orange Liberia.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9841,618,20,'National','Liberia','LR',120,'LIBTELCO','Liberia Telecommunications Corporation','Operational','CDMA2000',''),
	 (9842,606,0,'National','Libya','LY',121,'Libyana','Libyana','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE',''),
	 (9843,606,1,'National','Libya','LY',121,'Madar','Al-Madar Al-Jadeed','Operational','GSM 900 / GSM 1800',''),
	 (9844,606,2,'National','Libya','LY',121,'Al-Jeel Phone','Al-Jeel Al-Jadeed','Operational','GSM 900 / GSM 1800','Uses Al-Madar for frequency access');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9845,606,3,'National','Libya','LY',121,'Libya Phone','Libya Telecom & Technology (LTT)','Operational','GSM 900 / GSM 1800 / UMTS 2100','Uses Libyana for frequency access'),
	 (9846,606,6,'National','Libya','LY',121,'Hatef Libya','Hatef Libya','Operational','CDMA2000',''),
	 (9847,295,1,'National','Liechtenstein','LI',122,'Swisscom','Swisscom Schweiz AG','Operational','GSM 900 / GSM 1800 / LTE 1800','Also uses MCC 228 MNC 01 (Switzerland)'),
	 (9848,295,2,'National','Liechtenstein','LI',122,'7acht','Salt Liechtenstein AG','Operational','GSM 1800 / UMTS 2100 / LTE 1800','Former Orange'),
	 (9849,295,5,'National','Liechtenstein','LI',122,'FL1','Telecom Liechtenstein AG','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','Former Mobilkom'),
	 (9850,295,6,'National','Liechtenstein','LI',122,'Cubic Telecom','Cubic Telecom AG','Operational','MVNO',''),
	 (9851,295,7,'National','Liechtenstein','LI',122,'','First Mobile AG','Unknown','MVNO',''),
	 (9852,295,9,'National','Liechtenstein','LI',122,'','EMnify GmbH','Unknown','MVNO',''),
	 (9853,295,10,'National','Liechtenstein','LI',122,'','Soracom LI Ltd.','Unknown','MVNO',''),
	 (9854,295,77,'National','Liechtenstein','LI',122,'Alpmobil','Alpcom AG','Not operational','GSM 900','Bankruptcy in February 2012, former Tele2, MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9855,246,1,'National','Lithuania','LT',123,'Telia','Telia Lietuva','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Former Omnitel'),
	 (9856,246,2,'National','Lithuania','LT',123,'BITĖ','UAB Bitė Lietuva','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9857,246,3,'National','Lithuania','LT',123,'Tele2','UAB Tele2 (Tele2 AB, Sweden)','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','(in Vodafone partnership)'),
	 (9858,246,4,'National','Lithuania','LT',123,'','LR vidaus reikalų ministerija (Ministry of the Interior)','Unknown','Unknown',''),
	 (9859,246,5,'National','Lithuania','LT',123,'LitRail','Lietuvos geležinkeliai (Lithuanian Railways)','Operational','GSM-R 900',''),
	 (9860,246,6,'National','Lithuania','LT',123,'Mediafon','UAB Mediafon','Operational','Unknown',''),
	 (9861,246,7,'National','Lithuania','LT',123,'','Compatel Ltd.','Unknown','Unknown',''),
	 (9862,246,8,'National','Lithuania','LT',123,'MEZON','Lietuvos radijo ir televizijos centras','Operational','WiMAX 3500 / TD-LTE 2300',''),
	 (9863,246,9,'National','Lithuania','LT',123,'','Interactive Digital Media GmbH','Unknown','Unknown',''),
	 (9864,270,1,'National','Luxembourg','LU',124,'POST','POST Luxembourg','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former LuxGSM (P&T Luxembourg)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9865,270,2,'National','Luxembourg','LU',124,'','MTX Connect S.a.r.l.','Unknown','Unknown',''),
	 (9866,270,7,'National','Luxembourg','LU',124,'','Bouygues Telecom S.A.','Unknown','Unknown',''),
	 (9867,270,10,'National','Luxembourg','LU',124,'','Blue Communications','Unknown','Unknown',''),
	 (9868,270,77,'National','Luxembourg','LU',124,'Tango','Tango SA','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','MNC also used in Belgium'),
	 (9869,270,78,'National','Luxembourg','LU',124,'','Interactive digital media GmbH','Unknown','Unknown',''),
	 (9870,270,79,'National','Luxembourg','LU',124,'','Mitto A.G.','Unknown','Unknown',''),
	 (9871,270,80,'National','Luxembourg','LU',124,'','Syniverse Technologies S.à r.l.','Unknown','Unknown',''),
	 (9872,270,81,'National','Luxembourg','LU',124,'','E-Lux Mobile Telecommunication S.A.','Unknown','Unknown',''),
	 (9873,270,99,'National','Luxembourg','LU',124,'Orange','Orange S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former VOXmobile'),
	 (9874,455,0,'National','Macau (People''s Republic of China)','MO',125,'SmarTone','Smartone – Comunicações Móveis, S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9875,455,1,'National','Macau (People''s Republic of China)','MO',125,'CTM','Companhia de Telecomunicações de Macau, S.A.R.L.','Operational','GSM 900 / GSM 1800 / LTE 1800',''),
	 (9876,455,2,'National','Macau (People''s Republic of China)','MO',125,'China Telecom','China Telecom (Macau) Company Limited','Operational','CDMA 800',''),
	 (9877,455,3,'National','Macau (People''s Republic of China)','MO',125,'3','Hutchison Telephone (Macau), Limitada','Operational','GSM 900 / GSM 1800',''),
	 (9878,455,4,'National','Macau (People''s Republic of China)','MO',125,'CTM','Companhia de Telecomunicações de Macau, S.A.R.L.','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9879,455,5,'National','Macau (People''s Republic of China)','MO',125,'3','Hutchison Telephone (Macau), Limitada','Operational','UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (9880,455,6,'National','Macau (People''s Republic of China)','MO',125,'SmarTone','Smartone – Comunicações Móveis, S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9881,455,7,'National','Macau (People''s Republic of China)','MO',125,'China Telecom','China Telecom (Macau) Limitada','Operational','LTE 1800',''),
	 (9882,294,1,'National','Macedonia','MK',126,'Telekom.mk','Makedonski Telekom','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800','Former Mobimak'),
	 (9883,294,2,'National','Macedonia','MK',126,'vip','ONE.VIP DOO','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800','Former Cosmofon, One (Telekom Slovenija Group)'),
	 (9884,294,3,'National','Macedonia','MK',126,'vip','ONE.VIP DOO','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800','Former VIP; merged with One in 2015');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9885,294,4,'National','Macedonia','MK',126,'Lycamobile','Lycamobile LLC','Operational','MVNO','Uses ONE.VIP network'),
	 (9886,294,10,'National','Macedonia','MK',126,'','WTI Macedonia','Not operational','Unknown',''),
	 (9887,294,11,'National','Macedonia','MK',126,'','MOBIK TELEKOMUNIKACII DOOEL Skopje','Unknown','Unknown',''),
	 (9888,646,1,'National','Madagascar','MG',127,'Airtel','Bharti Airtel','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE','Former Celtel (Zain), Madacom'),
	 (9889,646,2,'National','Madagascar','MG',127,'Orange','Orange Madagascar S.A.','Operational','GSM 900 / LTE 1800',''),
	 (9890,646,3,'National','Madagascar','MG',127,'Sacel','Sacel Madagascar S.A.','Not operational','GSM 900','license withdrawn in 2001'),
	 (9891,646,4,'National','Madagascar','MG',127,'Telma','Telma Mobile S.A.','Operational','GSM 900 / LTE 1800',''),
	 (9892,650,1,'National','Malawi','MW',128,'TNM','Telecom Network Malawi','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 2500',''),
	 (9893,650,2,'National','Malawi','MW',128,'Access','Access Communications Ltd','Operational','CDMA / LTE 850',''),
	 (9894,650,10,'National','Malawi','MW',128,'Airtel','Bharti Airtel Limited','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE','Former Celtel (Zain)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9895,502,1,'National','Malaysia','MY',129,'ATUR 450','Telekom Malaysia Bhd','Not operational','CDMA2000 450',''),
	 (9896,502,10,'National','Malaysia','MY',129,'','Maxis, DiGi, Celcom, XOX','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600','Former Celcom'),
	 (9897,502,11,'National','Malaysia','MY',129,'TM Homeline','Telekom Malaysia Bhd','Operational','CDMA2000 850 / LTE 850',''),
	 (9898,502,12,'National','Malaysia','MY',129,'Maxis','Maxis Communications Berhad','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600','Used by MVNO Kartu As; LTE 2600 in co-operation with REDtone'),
	 (9899,502,13,'National','Malaysia','MY',129,'Celcom','Celcom Axiata Berhad','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600','Former Emartel, TMTouch; LTE 2600 in co-operation with Altel'),
	 (9900,502,14,'National','Malaysia','MY',129,'','Telekom Malaysia Berhad for PSTN SMS','Unknown','',''),
	 (9901,502,150,'National','Malaysia','MY',129,'Tune Talk','Tune Talk Sdn Bhd','Operational','MVNO','uses Celcom'),
	 (9902,502,151,'National','Malaysia','MY',129,'SalamFone','Baraka Telecom Sdn Bhd','Not operational','MVNO','(MVNO)-MAXIS, previously using DiGi; MNC withdrawn'),
	 (9903,502,152,'National','Malaysia','MY',129,'Yes','YTL Communications Sdn Bhd','Operational','WiMAX 2300 / TD-LTE 2300 / TD-LTE 2600',''),
	 (9904,502,153,'National','Malaysia','MY',129,'unify','Webe Digital Sdn Bhd','Operational','WiMAX 2300 / LTE 850','Former Packet One Networks; subsidiary of Telekom Malaysia');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9905,502,154,'National','Malaysia','MY',129,'Tron','Talk Focus Sdn Bhd','Operational','MVNO','Uses Digi'),
	 (9906,502,155,'National','Malaysia','MY',129,'Clixster','Clixster Mobile Sdn Bhd','Not operational','MVNO','Uses Digi; MNC withdrawn'),
	 (9907,502,156,'National','Malaysia','MY',129,'Altel','Altel Communications Sdn Bhd','Operational','MVNO','Using Celcom; LTE 2600 band licensed to Celcom'),
	 (9908,502,157,'National','Malaysia','MY',129,'Telin','Telekomunikasi Indonesia International (M) Sdn Bhd','Operational','MVNO','Uses U Mobile'),
	 (9909,502,16,'National','Malaysia','MY',129,'DiGi','DiGi Telecommunications','Operational','GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2600','LTE 2600 coverage limited to certain areas in the Klang Valley at the moment; former Mutiara Telecom'),
	 (9910,502,17,'National','Malaysia','MY',129,'Maxis','Maxis Communications Berhad','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','Former TimeCel, Adam017'),
	 (9911,502,18,'National','Malaysia','MY',129,'U Mobile','U Mobile Sdn Bhd','Operational','UMTS 2100 / LTE 1800 / LTE 2600','Domestic Roaming with Maxis, also for GSM Former Mobikom'),
	 (9912,502,19,'National','Malaysia','MY',129,'Celcom','Celcom Axiata Berhad','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600',''),
	 (9913,502,20,'National','Malaysia','MY',129,'Electcoms','Electcoms Berhad','Operational','DMR','Uses TM CDMA'),
	 (9914,472,1,'National','Maldives','MV',130,'Dhiraagu','Dhivehi Raajjeyge Gulhun','Operational','GSM 900 / UMTS 2100 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9915,472,2,'National','Maldives','MV',130,'Ooredoo','Wataniya Telecom Maldives','Operational','GSM 900 / UMTS 2100 / LTE 2600',''),
	 (9916,610,1,'National','Mali','ML',131,'Malitel','Malitel SA','Operational','GSM 900',''),
	 (9917,610,2,'National','Mali','ML',131,'Orange','Orange Mali SA','Operational','GSM 900 / LTE',''),
	 (9918,610,3,'National','Mali','ML',131,'ATEL-SA','Alpha Telecommunication Mali S.A.','Operational','GSM 900 / UMTS 2100',''),
	 (9919,278,1,'National','Malta','MT',132,'Vodafone','Vodafone Malta','Operational','GSM 900 / UMTS 2100 / LTE 1800','Supports MVNO Redtouch Fone and MVNO VFC Mobile'),
	 (9920,278,11,'National','Malta','MT',132,'','YOM Ltd.','Operational','MVNO',''),
	 (9921,278,21,'National','Malta','MT',132,'GO','Mobile Communications Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Supports MVNO PING'),
	 (9922,278,30,'National','Malta','MT',132,'GO','Mobile Communications Limited','Unknown','Unknown',''),
	 (9923,278,77,'National','Malta','MT',132,'Melita','Melita','Operational','UMTS 900 / UMTS 2100',''),
	 (9924,551,1,'National','Marshall Islands','MH',133,'','Marshall Islands National Telecommunications Authority (MINTA)','Operational','GSM 900 / GSM 1800 / LTE 700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9925,609,1,'National','Mauritania','MR',135,'Mattel','Mattel','Operational','GSM 900',''),
	 (9926,609,2,'National','Mauritania','MR',135,'Chinguitel','Chinguitel','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9927,609,10,'National','Mauritania','MR',135,'Mauritel','Mauritel Mobiles','Operational','GSM 900',''),
	 (9928,617,1,'National','Mauritius','MU',136,'my.t','Cellplus Mobile Communications Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Orange'),
	 (9929,617,2,'National','Mauritius','MU',136,'MOKOZE / AZU','Mahanagar Telephone Mauritius Limited (MTML)','Operational','CDMA2000',''),
	 (9930,617,3,'National','Mauritius','MU',136,'CHILI','Mahanagar Telephone Mauritius Limited (MTML)','Operational','GSM 900 / LTE 1800',''),
	 (9931,617,10,'National','Mauritius','MU',136,'Emtel','Emtel Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9932,334,1,'National','Mexico','MX',138,'','Comunicaciones Digitales Del Norte, S.A. de C.V.','Unknown','Unknown',''),
	 (9933,334,10,'National','Mexico','MX',138,'AT&T','AT&T Mexico','Operational','iDEN 800','Former Nextel'),
	 (9934,334,20,'National','Mexico','MX',138,'Telcel','América Móvil','Operational','GSM 1900 / UMTS 850 / UMTS 1900 / LTE 1700 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9935,334,30,'National','Mexico','MX',138,'Movistar','Telefónica','Operational','GSM 1900 / UMTS 850 / LTE 1900','formerly Pegaso Comunicaciones y Sistemas; used by MVNO Virgin Mobile'),
	 (9936,334,40,'National','Mexico','MX',138,'Unefon','AT&T Mexico','Not operational','CDMA2000 800 / CDMA2000 1900','Shut down 2016'),
	 (9937,334,50,'National','Mexico','MX',138,'AT&T / Unefon','AT&T Mexico','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / UMTS 1700 / LTE 850 / LTE 1700','Former Iusacell'),
	 (9938,334,60,'National','Mexico','MX',138,'','Servicios de Acceso Inalambrico, S.A. de C.V.','Unknown','Unknown',''),
	 (9939,334,66,'National','Mexico','MX',138,'','Telefonos de México, S.A.B. de C.V.','Unknown','Unknown',''),
	 (9940,334,70,'National','Mexico','MX',138,'Unefon','AT&T Mexico','Unknown','Unknown',''),
	 (9941,334,80,'National','Mexico','MX',138,'Unefon','AT&T Mexico','Unknown','Unknown',''),
	 (9942,334,90,'National','Mexico','MX',138,'AT&T','AT&T Mexico','Operational','UMTS 1700 / LTE 850 / LTE 1700','Former Nextel'),
	 (9943,334,140,'National','Mexico','MX',138,'Altan Redes','Altán Redes S.A.P.I. de C.V.','Operational','LTE 700','Red compartida'),
	 (9944,550,1,'National','Federated States of Micronesia','FM',139,'','FSMTC','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9945,259,1,'National','Moldova','MD',140,'Orange','Orange Moldova','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Voxtel'),
	 (9946,259,2,'National','Moldova','MD',140,'Moldcell','','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / LTE 2600',''),
	 (9947,259,3,'National','Moldova','MD',140,'IDC','Interdnestrcom','Operational','CDMA 450 / CDMA 800','Sharing the same MNC with Unité'),
	 (9949,259,4,'National','Moldova','MD',140,'Eventis','Eventis Telecom','Not operational','GSM 900 / GSM 1800','Bankruptcy - License suspended'),
	 (9950,259,5,'National','Moldova','MD',140,'Unité','Moldtelecom','Operational','UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (9951,259,15,'National','Moldova','MD',140,'IDC','Interdnestrcom','Operational','LTE 800',''),
	 (9952,259,99,'National','Moldova','MD',140,'Unité','Moldtelecom','Operational','UMTS 2100','Used for Femtocell service only'),
	 (9953,212,10,'National','Monaco','MC',141,'Office des Telephones','Monaco Telecom','Operational','GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Used for the Vala network in Kosovo. The GSM Association lists the PTK (P&T Kosovo) website for this network.'),
	 (9954,428,88,'National','Mongolia','MN',142,'Unitel','Unitel LLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9955,428,91,'National','Mongolia','MN',142,'Skytel','Skytel LLC','Operational','CDMA2000 800 / UMTS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9956,428,98,'National','Mongolia','MN',142,'G-Mobile','G-Mobile LLC','Operational','CDMA2000 450 / UMTS 2100',''),
	 (9957,428,99,'National','Mongolia','MN',142,'Mobicom','Mobicom Corporation','Operational','GSM 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (9958,297,1,'National','Montenegro','ME',242,'Telenor','Telenor Montenegro','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former ProMonte GSM'),
	 (9959,297,2,'National','Montenegro','ME',242,'T-Mobile','T-Mobile Montenegro LLC','Operational','GSM 900 / UMTS 2100 / LTE 1800',''),
	 (9960,297,3,'National','Montenegro','ME',242,'m:tel CG','MTEL CG','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9961,354,860,'National','Montserrat (United Kingdom)','MS',143,'FLOW','Cable & Wireless','Operational','GSM 850',''),
	 (9962,604,0,'National','Morocco','MA',144,'Orange Morocco','Médi Télécom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Former Méditel'),
	 (9963,604,1,'National','Morocco','MA',144,'IAM','Ittissalat Al-Maghrib (Maroc Telecom)','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 2600',''),
	 (9964,604,2,'National','Morocco','MA',144,'INWI','Wana Corporate','Operational','GSM 900 / GSM 1800',''),
	 (9965,604,4,'National','Morocco','MA',144,'','Al Houria Telecom','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9966,604,5,'National','Morocco','MA',144,'INWI','Wana Corporate','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (9967,604,6,'National','Morocco','MA',144,'IAM','Ittissalat Al-Maghrib (Maroc Telecom)','Unknown','Unknown',''),
	 (9968,604,99,'National','Morocco','MA',144,'','Al Houria Telecom','Unknown','Unknown',''),
	 (9969,643,1,'National','Mozambique','MZ',145,'mCel','Mocambique Celular S.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100',''),
	 (9970,643,3,'National','Mozambique','MZ',145,'Movitel','Movitel, SA','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9971,643,4,'National','Mozambique','MZ',145,'Vodacom','Vodacom Mozambique, S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (9972,414,0,'National','Myanmar','MM',146,'MPT','Myanmar Posts and Telecommunications','Unknown','Unknown',''),
	 (9973,414,1,'National','Myanmar','MM',146,'MPT','Myanmar Posts and Telecommunications','Operational','GSM 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (9974,414,2,'National','Myanmar','MM',146,'MPT','Myanmar Posts and Telecommunications','Unknown','Unknown',''),
	 (9975,414,3,'National','Myanmar','MM',146,'CDMA800','Myanmar Economic Corporation','Operational','CDMA 800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9976,414,4,'National','Myanmar','MM',146,'MPT','Myanmar Posts and Telecommunications','Unknown','Unknown',''),
	 (9977,414,5,'National','Myanmar','MM',146,'Ooredoo','Ooredoo Myanmar','Operational','UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (9978,414,6,'National','Myanmar','MM',146,'Telenor','Telenor Myanmar','Operational','GSM 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (9979,414,9,'National','Myanmar','MM',146,'Mytel','Myanmar National Tele & Communication Co., Ltd','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 2100',''),
	 (9980,649,1,'National','Namibia','NA',147,'MTC','MTC Namibia','Operational','GSM 900 / GSM 1800 / LTE 800 / LTE 1800',''),
	 (9981,649,2,'National','Namibia','NA',147,'switch','Telecom Namibia','Operational','CDMA2000 800',''),
	 (9982,649,3,'National','Namibia','NA',147,'TN Mobile','Telecom Namibia','Operational','GSM 900 / GSM 1800 / LTE 1800 / LTE 2600','former Cell One'),
	 (9983,649,4,'National','Namibia','NA',147,'','Paratus Telecommunications (Pty)','Operational','WiMAX 2500','former ITN/WTN'),
	 (9984,649,5,'National','Namibia','NA',147,'','Demshi Investments CC','Unknown','Unknown',''),
	 (9985,536,2,'National','Nauru','NR',148,'Digicel','Digicel (Nauru) Corporation','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Also uses MCC 542 MNC 02 (Fiji)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9986,429,1,'National','Nepal','NP',149,'Namaste / NT Mobile / Sky Phone','Nepal Telecom (NDCL)','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / CDMA / WiMAX',''),
	 (9987,429,2,'National','Nepal','NP',149,'Ncell','Ncell Pvt. Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (9988,429,3,'National','Nepal','NP',149,'UTL','United Telecom Limited','Operational','CDMA2000 800',''),
	 (9989,429,4,'National','Nepal','NP',149,'SmartCell','Smart Telecom Pvt. Ltd. (STPL)','Operational','GSM 900 / LTE 1800',''),
	 (9990,204,1,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','RadioAccess Network Services','Unknown','Unknown',''),
	 (9991,204,2,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Tele2','Tele2 Nederland B.V.','Operational','LTE 800 / LTE 2600','2G and 3G National Roaming Agreement on T-Mobile Netherlands'),
	 (9992,204,3,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Voiceworks','Voiceworks B.V.','Operational','MVNE / PrivateGSM 1800',''),
	 (9993,204,4,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Vodafone','Vodafone Libertel B.V.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (9994,204,5,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Elephant Talk Communications Premium Rate Services','Unknown','Unknown',''),
	 (9995,204,6,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Vectone Mobile','Mundio Mobile (Netherlands) Ltd','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (9996,204,7,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Teleena (MVNO)','Teleena (MVNE)','Operational','MVNE',''),
	 (9997,204,8,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'KPN','KPN Mobile The Netherlands B.V.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (9998,204,9,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Lycamobile','Lycamobile Netherlands Limited','Operational','MVNO',''),
	 (9999,204,10,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'KPN','KPN B.V.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10000,204,11,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','VoipIT B.V.','Unknown','Unknown',''),
	 (10001,204,12,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Telfort','KPN Mobile The Netherlands B.V.','Operational','','Subbrand of KPN, National Roaming Agreement on KPN'),
	 (10002,204,13,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Unica Installatietechniek B.V.','Unknown','Unknown',''),
	 (10003,204,14,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','6GMOBILE B.V.','Reserved','','went into Bankruptcy'),
	 (10004,204,15,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Ziggo','Ziggo B.V.','Operational','LTE 2600','business users only'),
	 (10005,204,16,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'T-Mobile (BEN)','T-Mobile Netherlands B.V','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10006,204,17,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Intercity Zakelijk','Intercity Mobile Communications B.V.','Operational','MVNE',''),
	 (10007,204,18,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'upc','UPC Nederland B.V.','Operational','MVNO',''),
	 (10008,204,19,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Mixe Communication Solutions B.V.','Unknown','Unknown',''),
	 (10009,204,20,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'T-Mobile','T-Mobile Netherlands B.V','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100 / LTE 2600','Former Orange Netherlands MCC/MNC'),
	 (10010,204,21,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','ProRail B.V.','Operational','GSM-R 900',''),
	 (10011,204,22,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Ministerie van Defensie','Unknown','Unknown',''),
	 (10012,204,23,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Wyless Nederland B.V.','Operational','MVNE','Former ASPIDER Solutions; now owned by KORE Wireless'),
	 (10013,204,24,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Private Mobility Nederland B.V.','Unknown','Unknown',''),
	 (10014,204,25,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','CapX B.V.','Operational','PrivateGSM 1800',''),
	 (10015,204,26,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','SpeakUp B.V.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10016,204,27,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Breezz Nederland B.V.','Unknown','Unknown',''),
	 (10017,204,28,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Lancelot B.V.','Unknown','Unknown',''),
	 (10018,204,29,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Private Mobile Ltd','Unknown','Unknown',''),
	 (10019,204,60,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Nextgen Mobile Ltd','Unknown','Unknown',''),
	 (10020,204,61,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','BodyTrace Netherlands B.V.','Operational','MVNO',''),
	 (10021,204,62,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'Voxbone','Voxbone mobile','Operational','MVNO',''),
	 (10022,204,64,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Zetacom B.V.','Unknown','Unknown',''),
	 (10023,204,65,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','AGMS Netherlands B.V.','Unknown','Unknown',''),
	 (10024,204,66,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Utility Connect B.V.','Operational','CDMA 450','Subsidiary of Alliander; network operated by KPN'),
	 (10025,204,67,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Koning en Hartman B.V.','Operational','PrivateGSM 1800','Former RadioAccess B.V.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10026,204,68,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','Roamware (Netherlands) B.V.','Unknown','Unknown',''),
	 (10027,204,69,'National','Netherlands (Kingdom of the Netherlands)','NL',150,'','KPN Mobile The Netherlands B.V.','Unknown','',''),
	 (10028,362,31,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'','Eutel N.V.','Unknown','GSM','Sint Eustatius'),
	 (10029,362,33,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'','WICC N.V.','Unknown','GSM',''),
	 (10030,362,51,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Telcell','Telcell N.V.','Operational','GSM 900 / UMTS 2100 / LTE 1800','Sint Maarten'),
	 (10031,362,54,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'ECC','East Caribbean Cellular','Operational','GSM 900 / GSM 1800',''),
	 (10032,362,59,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Chippie','United Telecommunication Service N.V. (UTS)','Operational','GSM 900 / GSM 1800','Bonaire, Saba, Sint Eustatius, Sint Maarten; former Radcomm N.V.'),
	 (10033,362,60,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Chippie','United Telecommunication Service N.V. (UTS)','Operational','UMTS 2100 / LTE 1800','Bonaire, Saba, Sint Eustatius, Sint Maarten; former Radcomm N.V.'),
	 (10034,362,63,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'','CSC N.V.','Unknown','Unknown',''),
	 (10035,362,68,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Digicel','Curaçao Telecom N.V.','Operational','UMTS 2100 / LTE 1800','Curaçao');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10036,362,69,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Digicel','Curaçao Telecom N.V.','Operational','GSM 900 / GSM 1800','Curaçao'),
	 (10037,362,74,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'','PCS N.V.','Unknown','Unknown',''),
	 (10038,362,76,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Digicel','Antiliano Por N.V.','Operational','GSM 900 / UMTS','Bonaire'),
	 (10039,362,78,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Telbo','Telefonia Bonairiano N.V.','Operational','UMTS 900 / LTE 1800','Bonaire'),
	 (10040,362,91,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Chippie','United Telecommunication Service N.V. (UTS)','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 1800','Curaçao; former Setel N.V.'),
	 (10041,362,94,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'Bayòs','Bòbò Frus N.V.','Operational','TDMA PCS','Mobile Solutions'),
	 (10042,362,95,'National','Former Netherlands Antilles (Kingdom of the Netherlands)','BQ/CW/SX',0,'MIO','E.O.C.G. Wireless','Not operational','CDMA2000 850','former GSM Caribbean N.V.; bankrupt in 2013'),
	 (10043,546,1,'National','New Caledonia (France)','NC',152,'Mobilis','OPT New Caledonia','Operational','GSM 900 / UMTS 900 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10044,530,0,'National','New Zealand','NZ',153,'Telecom','Telecom New Zealand','Not operational','AMPS 800 / TDMA 800','Shut down on 31 March 2007'),
	 (10045,530,1,'National','New Zealand','NZ',153,'Vodafone','Vodafone New Zealand','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600','UMTS 2100 is used in urban areas. UMTS 900 is referred to as \"3G extended\" and used in rural areas.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10046,530,2,'National','New Zealand','NZ',153,'Telecom','Telecom New Zealand','Not operational','CDMA2000 800','Shut down on 31 July 2012'),
	 (10047,530,3,'National','New Zealand','NZ',153,'Woosh','Woosh Wireless','Operational','UMTS-TDD 2000','Former Walker Wireless; wireless broadband only'),
	 (10048,530,4,'National','New Zealand','NZ',153,'Vodafone','TelstraClear New Zealand','Not operational','UMTS 2100','Former TelstraClear'),
	 (10049,530,5,'National','New Zealand','NZ',153,'Spark','Spark New Zealand','Operational','UMTS 850 / UMTS 2100 / LTE 700 / LTE 1800 / TD-LTE 2300 / LTE 2600','Formerly Telecom New Zealand, Xtra'),
	 (10050,530,6,'National','New Zealand','NZ',153,'Skinny','Spark New Zealand','Operational','MVNO',''),
	 (10051,530,7,'National','New Zealand','NZ',153,'','Bluereach Limited','Unknown','Unknown',''),
	 (10052,530,24,'National','New Zealand','NZ',153,'2degrees','2degrees','Operational','UMTS 900 / UMTS 2100 / LTE 700 / LTE 900 / LTE 1800',''),
	 (10053,710,21,'National','Nicaragua','NI',154,'Claro','Empresa Nicaragüense de Telecomunicaciones, S.A. (ENITEL) (América Móvil)','Operational','GSM 1900 / UMTS 850 / LTE 1700',''),
	 (10054,710,30,'National','Nicaragua','NI',154,'movistar','Telefonía Celular de Nicaragua, S.A. (Telefónica, S.A.)','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 1900','CDMA 800, TDMA 800, and NAMPS 800 have been shut down'),
	 (10055,710,73,'National','Nicaragua','NI',154,'Claro','Servicios de Comunicaciones S.A.','Operational','GSM 1900 / UMTS 850','Former SERCOM (Merged with ENITEL in 2004 and became Claro in 2009)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10056,614,1,'National','Niger','NE',155,'SahelCom','La Société Sahélienne de Télécommunications (SahelCom)','Operational','GSM 900',''),
	 (10057,614,2,'National','Niger','NE',155,'Airtel','Bharti Airtel Limited','Operational','GSM 900','formerly Zain and Celtel'),
	 (10058,614,3,'National','Niger','NE',155,'Moov','Atlantique Telecom (subsidiary of Etisalat)','Operational','GSM 900','Former Telecel'),
	 (10059,614,4,'National','Niger','NE',155,'Orange','Orange Niger','Operational','GSM 900 / GSM 1800',''),
	 (10060,621,0,'National','Nigeria','NG',156,'','Capcom','Not operational','LTE 1900','Former Starcomms, MultiLinks, and MTS First Wireless'),
	 (10061,621,20,'National','Nigeria','NG',156,'Airtel','Bharti Airtel Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Zain, V-Mobile'),
	 (10062,621,22,'National','Nigeria','NG',156,'InterC','InterC Network Ltd.','Operational','LTE 800','Former Intercellular; LTE band 20'),
	 (10063,621,24,'National','Nigeria','NG',156,'','Spectranet','Operational','TD-LTE 2300',''),
	 (10064,621,25,'National','Nigeria','NG',156,'Visafone','Visafone Communications Ltd.','Not operational','CDMA2000 800 / CDMA2000 1900','Acquired by MTN'),
	 (10065,621,26,'National','Nigeria','NG',156,'','Swift','Operational','TD-LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10066,621,27,'National','Nigeria','NG',156,'Smile','Smile Communications Nigeria','Operational','LTE 800','LTE band 20'),
	 (10067,621,30,'National','Nigeria','NG',156,'MTN','MTN Nigeria Communications Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 2600 / LTE 3500',''),
	 (10068,621,40,'National','Nigeria','NG',156,'Ntel','Nigerian Mobile Telecommunications Limited','Operational','LTE 900 / LTE 1800','Former M-Tel; LTE bands 8 / 3'),
	 (10069,621,50,'National','Nigeria','NG',156,'Glo','Globacom Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 700','LTE band 28'),
	 (10070,621,60,'National','Nigeria','NG',156,'9mobile','','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Until 2017, Emerging Markets Telecommunication Services Ltd (Etisalat)'),
	 (10071,555,1,'National','Niue','NU',157,'Telecom Niue','Telecom Niue','Operational','GSM 900',''),
	 (10072,505,10,'National','Norfolk Island','NF',158,'Norfolk Telecom','Norfolk Telecom','Operational','GSM 900',''),
	 (10073,310,110,'National','Northern Mariana Islands (United States of America)','MP',159,'IT&E Wireless','PTI Pacifica Inc.','Operational','CDMA / GSM 850 / LTE 700',''),
	 (10074,310,370,'National','Northern Mariana Islands (United States of America)','MP',159,'Docomo','NTT Docomo Pacific','Operational','GSM 1900 / UMTS / LTE',''),
	 (10075,242,1,'National','Norway','NO',160,'Telenor','Telenor Norge AS','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10076,242,2,'National','Norway','NO',160,'Telia','TeliaSonera Norge AS','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former NetCom'),
	 (10077,242,3,'National','Norway','NO',160,'','Televerket AS','Not operational','Unknown','MNC withdrawn'),
	 (10078,242,4,'National','Norway','NO',160,'Tele2','Tele2 (Mobile Norway AS)','Not operational','MVNO','MNC withdrawn'),
	 (10079,242,5,'National','Norway','NO',160,'Telia','TeliaSonera Norge AS','Not operational','GSM 900 / UMTS 900 / UMTS 2100','Former Tele2'),
	 (10080,242,6,'National','Norway','NO',160,'ICE','ICE Norge AS','Operational','LTE 450','Former Nordisk Mobiltelefon; data services only'),
	 (10081,242,7,'National','Norway','NO',160,'Phonero','Phonero AS','Not operational','MVNO','Former Ventelo; MNC withdrawn'),
	 (10082,242,8,'National','Norway','NO',160,'TDC','TDC Mobil AS','Operational','MVNO',''),
	 (10083,242,9,'National','Norway','NO',160,'Com4','Com4 AS','Operational','MVNO','Principally M2M services'),
	 (10084,242,10,'National','Norway','NO',160,'','Norwegian Communications Authority','Unknown','Unknown',''),
	 (10085,242,11,'National','Norway','NO',160,'SystemNet','SystemNet AS','Unknown','Test','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10086,242,12,'National','Norway','NO',160,'Telenor','Telenor Norge AS','Unknown','Unknown',''),
	 (10087,242,14,'National','Norway','NO',160,'ICE','ICE Communication Norge AS','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10088,242,20,'National','Norway','NO',160,'','Jernbaneverket AS','Operational','GSM-R 900',''),
	 (10089,242,21,'National','Norway','NO',160,'','Jernbaneverket AS','Operational','GSM-R 900',''),
	 (10090,242,22,'National','Norway','NO',160,'','Altibox AS','Unknown','Unknown','Former Network Norway AS'),
	 (10091,242,23,'National','Norway','NO',160,'Lycamobile','Lyca Mobile Ltd','Operational','MVNO',''),
	 (10092,242,24,'National','Norway','NO',160,'','Mobile Norway AS','Not operational','Unknown','MNC withdrawn'),
	 (10093,242,25,'National','Norway','NO',160,'','Forsvarets kompetansesenter KKIS','Unknown','Unknown',''),
	 (10094,242,90,'National','Norway','NO',160,'','Nokia Solutions and Networks Norge AS','Unknown','Unknown',''),
	 (10095,242,99,'National','Norway','NO',160,'','TampNet AS','Operational','LTE','Offshore');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10096,422,2,'National','Oman','OM',161,'Omantel','Oman Telecommunications Company','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 1800 / TD-LTE 2300',''),
	 (10097,422,3,'National','Oman','OM',161,'ooredoo','Omani Qatari Telecommunications Company SAOC','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 800 / LTE 1800 / TD-LTE 2300','Former Nawras'),
	 (10098,422,4,'National','Oman','OM',161,'Omantel','Oman Telecommunications Company','Unknown','Unknown',''),
	 (10099,410,1,'National','Pakistan','PK',162,'Jazz','Mobilink-PMCL','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Mobilink'),
	 (10100,410,2,'National','Pakistan','PK',162,'PTCL','PTCL','Operational','CDMA2000 1900',''),
	 (10101,410,3,'National','Pakistan','PK',162,'Ufone','Pakistan Telecommunication Mobile Ltd','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100',''),
	 (10102,410,4,'National','Pakistan','PK',162,'Zong','China Mobile','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Paktel'),
	 (10103,410,5,'National','Pakistan','PK',162,'SCO Mobile','SCO Mobile Ltd','Operational','GSM 900 / GSM 1800',''),
	 (10104,410,6,'National','Pakistan','PK',162,'Telenor','Telenor Pakistan','Operational','GSM 900 / GSM 1800 / UMTS 2100 / UMTS 850 / LTE 850 / LTE 1800',''),
	 (10105,410,7,'National','Pakistan','PK',162,'Jazz','WaridTel','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former Warid Pakistan');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10106,410,8,'National','Pakistan','PK',162,'SCO Mobile','SCO Mobile Ltd','Operational','GSM 900 / GSM 1800',''),
	 (10107,552,1,'National','Palau','PW',163,'PNCC','Palau National Communications Corp.','Operational','GSM 900 / UMTS 900 / LTE 700',''),
	 (10108,552,2,'National','Palau','PW',163,'PalauTel','Palau Equipment Company Inc.','Unknown','Unknown',''),
	 (10109,552,80,'National','Palau','PW',163,'Palau Mobile','Palau Mobile Corporation','Not operational','GSM 1800','Service shutdown in 2014'),
	 (10110,425,5,'National','Palestine','PS',164,'Jawwal','Palestine Cellular Communications, Ltd.','Operational','GSM 900',''),
	 (10111,425,6,'National','Palestine','PS',164,'Wataniya','Wataniya Palestine Mobile Telecommunications Company','Operational','GSM 900 / GSM 1800','[2] (Ooredoo)'),
	 (10112,714,1,'National','Panama','PA',165,'Cable & Wireless','Cable & Wireless Panama S.A.','Operational','GSM 850 / UMTS 850 / LTE 700','LTE band 28'),
	 (10113,714,2,'National','Panama','PA',165,'movistar','Telefónica Moviles Panama S.A, Bell South Corp. (BSC)','Operational','GSM 850 / UMTS 850 / UMTS 1900 / LTE 700','CDMA2000 800, TDMA 800 and NAMPS 800 are closed.'),
	 (10114,714,3,'National','Panama','PA',165,'Claro','América Móvil','Operational','GSM 1900 / UMTS 1900 / LTE 700 / LTE 1900','LTE band 28'),
	 (10115,714,4,'National','Panama','PA',165,'Digicel','Digicel Group','Operational','GSM 1900 / UMTS 1900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10116,537,1,'National','Papua New Guinea','PG',166,'bmobile','Bemobile Limited','Operational','GSM 900 / UMTS 900',''),
	 (10117,537,2,'National','Papua New Guinea','PG',166,'citifon','Telikom PNG Ltd.','Operational','CDMA2000 450 / LTE 700','Formerly Greencom; LTE band 28'),
	 (10118,537,3,'National','Papua New Guinea','PG',166,'Digicel','Digicel PNG','Operational','GSM 900 / UMTS 900 / LTE 700','LTE band 28'),
	 (10119,744,1,'National','Paraguay','PY',167,'VOX','Hola Paraguay S.A','Operational','GSM 1900 / UMTS 900',''),
	 (10120,744,2,'National','Paraguay','PY',167,'Claro/Hutchison','AMX Paraguay S.A.','Operational','GSM 1900 / UMTS 1900 / LTE 1700',''),
	 (10121,744,3,'National','Paraguay','PY',167,'','Compañia Privada de Comunicaciones S.A.','Unknown','Unknown',''),
	 (10122,744,4,'National','Paraguay','PY',167,'Tigo','Telefónica Celular Del Paraguay S.A. (Telecel)','Operational','GSM 850 / UMTS 850 / LTE 1700',''),
	 (10123,744,5,'National','Paraguay','PY',167,'Personal','Núcleo S.A(TIM)','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 1900',''),
	 (10124,744,6,'National','Paraguay','PY',167,'Copaco','Copaco S.A.','Operational','GSM 1800 / LTE 1700',''),
	 (10125,716,6,'National','Peru','PE',168,'Movistar','Telefónica del Perú S.A.A.','Operational','CDMA2000 850 / GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900 / LTE 700 / LTE 1700','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10126,716,7,'National','Peru','PE',168,'Entel','Entel Perú S.A.','Operational','iDEN','Former Nextel'),
	 (10127,716,10,'National','Peru','PE',168,'Claro','América Móvil Perú','Operational','GSM 1900 / UMTS 850 / LTE 700 / LTE 1900 / TD-LTE 3500','Former TIM'),
	 (10128,716,15,'National','Peru','PE',168,'Bitel','Viettel Peru S.A.C.','Operational','GSM 1900 / UMTS 1900 / LTE 900',''),
	 (10129,716,17,'National','Peru','PE',168,'Entel','Entel Perú S.A.','Operational','UMTS 1900 / LTE 1700 / TD-LTE 2300','Former Nextel'),
	 (10130,515,1,'National','Philippines','PH',169,'Islacom','Globe Telecom via Innove Communications','Not operational','GSM 900',''),
	 (10131,515,2,'National','Philippines','PH',169,'Globe','Globe Telecom','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 900 / UMTS 2100 / LTE 700 / LTE 1800 / TD-LTE 2500',''),
	 (10132,515,3,'National','Philippines','PH',169,'SMART','PLDT via Smart Communications','Operational','GSM 900 / GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 850 / LTE 1800 / LTE 2100 / TD-LTE 2300 / TD-LTE 2500','Formerly PilTel'),
	 (10133,515,5,'National','Philippines','PH',169,'Sun Cellular','Digital Telecommunications Philippines','Operational','GSM 1800 / UMTS 2100','Uses SMART for LTE roaming'),
	 (10134,515,11,'National','Philippines','PH',169,'','PLDT via ACeS Philippines','Unknown','Unknown',''),
	 (10135,515,18,'National','Philippines','PH',169,'Cure','PLDT via Smart''s Connectivity Unlimited Resources Enterprise','Not operational','GSM 900 / UMTS 2100','Formerly ümobile, then Red Mobile; shut down 2012');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10136,515,24,'National','Philippines','PH',169,'ABS-CBN Mobile','ABS-CBN Convergence with Globe Telecom','Operational','MVNO',''),
	 (10137,515,88,'National','Philippines','PH',169,'','Next Mobile Inc.','Operational','iDEN','Former Nextel Philippines'),
	 (10138,0,0,'National','Pitcairn Islands (United Kingdom)','PN',170,'','','','',''),
	 (10139,260,1,'National','Poland','PL',171,'Plus','Polkomtel Sp. z o.o.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600','LTE roaming with Aero 2'),
	 (10140,260,2,'National','Poland','PL',171,'T-Mobile','T-Mobile Polska S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100','former Era; see MNC 260-34 for shared LTE network'),
	 (10141,260,3,'National','Poland','PL',171,'Orange','Polska Telefonia Komórkowa Centertel Sp. z o.o.','Operational','GSM 900 / GSM 1800 / UMTS 2100','former Idea; see MNC 260-34 for shared LTE network; CDMA2000 450 shut down April 2017'),
	 (10142,260,4,'National','Poland','PL',171,'Aero2','Aero 2 Sp. z o.o.','Not operational','Unknown','former CenterNet S.A.'),
	 (10143,260,5,'National','Poland','PL',171,'Orange','Polska Telefonia Komórkowa Centertel Sp. z o.o.','Not operational','UMTS 2100','not in use, using MNC 03'),
	 (10144,260,6,'National','Poland','PL',171,'Play','P4 Sp. z o.o.','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','Also roaming on Polkomtel and Orange 2G/3G network'),
	 (10145,260,7,'National','Poland','PL',171,'Netia','Netia S.A.','Operational','MVNO','MVNO on Play (P4)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10146,260,8,'National','Poland','PL',171,'','E-Telko Sp. z o.o.','Not operational','Unknown',''),
	 (10147,260,9,'National','Poland','PL',171,'Lycamobile','Lycamobile Sp. z o.o.','Operational','MVNO','On Polkomtel 2G/3G network'),
	 (10148,260,10,'National','Poland','PL',171,'T-Mobile','T-Mobile Polska S.A.','Unknown','Unknown','former Telefony Opalenickie S.A., Sferia; CDMA 800 shut down in 2014; LTE 800 leased to Aero 2;'),
	 (10149,260,11,'National','Poland','PL',171,'Nordisk Polska','Nordisk Polska Sp. z o.o.','Operational','CDMA2000 420',''),
	 (10150,260,12,'National','Poland','PL',171,'Cyfrowy Polsat','Cyfrowy Polsat S.A.','Operational','MVNO','MVNO on Polkomtel'),
	 (10151,260,13,'National','Poland','PL',171,'','Move Telecom S.A.','Unknown','Unknown','Former Sferia'),
	 (10152,260,14,'National','Poland','PL',171,'Sferia','Sferia S.A.','Not operational','','MNC withdrawn'),
	 (10153,260,15,'National','Poland','PL',171,'Aero2','Aero 2 Sp. z o.o.','Operational','LTE 1800','former CenterNet S.A.; combined network with Mobyland; GSM 1800 shut down in 2010'),
	 (10154,260,16,'National','Poland','PL',171,'Aero2','Aero 2 Sp. z o.o.','Operational','LTE 1800','former Mobyland; combined network with CenterNet; GSM 1800 shut down in 2010'),
	 (10155,260,17,'National','Poland','PL',171,'Aero2','Aero 2 Sp. z o.o.','Operational','UMTS 900 / LTE 800 / TD-LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10156,260,18,'National','Poland','PL',171,'AMD Telecom','AMD Telecom S.A.','Unknown','Unknown',''),
	 (10157,260,19,'National','Poland','PL',171,'Teleena','Teleena Holding BV','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10158,260,20,'National','Poland','PL',171,'Mobile.Net','Mobile.Net Sp. z o.o.','Not operational','Unknown','MNC withdrawn'),
	 (10159,260,21,'National','Poland','PL',171,'Exteri','Exteri Sp. z o.o.','Not operational','Unknown','MNC withdrawn May 2014'),
	 (10160,260,22,'National','Poland','PL',171,'Arcomm','Arcomm Sp. z o.o.','Unknown','Unknown',''),
	 (10161,260,23,'National','Poland','PL',171,'Amicomm','Amicomm Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10162,260,24,'National','Poland','PL',171,'','IT Partners Telco Sp. z o.o.','Unknown','Unknown','former WideNet Sp. z o.o.'),
	 (10163,260,25,'National','Poland','PL',171,'','Polskie Sieci Radiowe Sp. z o.o. Sp. k.a.','Not operational','Unknown','Former Best Solutions & Technology Experience Sp. z o.o. MNC withdrawn'),
	 (10164,260,26,'National','Poland','PL',171,'ATE','Advanced Technology & Experience Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10165,260,27,'National','Poland','PL',171,'Intertelcom','Intertelcom Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10166,260,28,'National','Poland','PL',171,'PhoneNet','PhoneNet Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10167,260,29,'National','Poland','PL',171,'Interfonica','Interfonica Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10168,260,30,'National','Poland','PL',171,'GrandTel','GrandTel Sp. z o.o.','Not operational','Unknown','MNC withdrawn July 2016'),
	 (10169,260,31,'National','Poland','PL',171,'Phone IT','Phone IT Sp. z o.o.','Not operational','Unknown','MNC withdrawn'),
	 (10170,260,32,'National','Poland','PL',171,'','Compatel Limited','Unknown','Unknown',''),
	 (10171,260,33,'National','Poland','PL',171,'Truphone','Truphone Poland Sp. z o.o.','Operational','MVNO',''),
	 (10172,260,34,'National','Poland','PL',171,'NetWorkS!','T-Mobile Polska S.A.','Operational','UMTS 900 / LTE 800 / LTE 1800 / LTE 2600','Shared network T-Mobile / Orange'),
	 (10173,260,35,'National','Poland','PL',171,'','PKP Polskie Linie Kolejowe S.A.','Operational','GSM-R',''),
	 (10174,260,36,'National','Poland','PL',171,'Vectone Mobile','Mundio Mobile','Not operational','MVNO','MNC withdrawn May 2014'),
	 (10175,260,37,'National','Poland','PL',171,'','NEXTGEN MOBILE LTD','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10176,260,38,'National','Poland','PL',171,'','CALLFREEDOM Sp. z o.o.','Unknown','Unknown',''),
	 (10177,260,39,'National','Poland','PL',171,'Voxbone','VOXBONE SA','Operational','MVNO',''),
	 (10178,260,40,'National','Poland','PL',171,'','Interactive Digital Media GmbH','Unknown','Unknown',''),
	 (10179,260,41,'National','Poland','PL',171,'','EZ PHONE MOBILE Sp. z o.o.','Unknown','Unknown',''),
	 (10180,260,42,'National','Poland','PL',171,'','MobiWeb Telecom Limited','Unknown','Unknown',''),
	 (10181,260,43,'National','Poland','PL',171,'','Smart Idea International Sp. z o.o.','Unknown','Unknown',''),
	 (10182,260,44,'National','Poland','PL',171,'','Rebtel Poland Sp. z o.o.','Unknown','Unknown',''),
	 (10183,260,45,'National','Poland','PL',171,'Virgin Mobile Polska Sp. z o.o.	','Virgin Mobile Polska Sp. z o.o.','Operational','MVNO',''),
	 (10184,260,46,'National','Poland','PL',171,'','Terra Telekom Sp. z o.o.','Unknown','Unknown',''),
	 (10185,260,47,'National','Poland','PL',171,'','SMShighway Limited','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10186,260,48,'National','Poland','PL',171,'','AGILE TELECOM S.P.A.','Unknown','Unknown',''),
	 (10187,260,49,'National','Poland','PL',171,'','Messagebird B.V.','Unknown','Unknown',''),
	 (10188,260,98,'National','Poland','PL',171,'Play','P4 Sp. z o.o.','Not operational','LTE 1800','Test network'),
	 (10189,268,1,'National','Portugal','PT',172,'Vodafone','Vodafone Portugal','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','formerly Telecel (2001)'),
	 (10190,268,2,'National','Portugal','PT',172,'MEO','Telecomunicações Móveis Nacionais','Unknown','Unknown',''),
	 (10191,268,3,'National','Portugal','PT',172,'NOS','NOS Comunicações','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','formerly Optimus (2014)'),
	 (10192,268,4,'National','Portugal','PT',172,'LycaMobile','LycaMobile','Operational','MVNO',''),
	 (10193,268,5,'National','Portugal','PT',172,'','Oniway - Inforcomunicaçôes, S.A.','Not operational','UMTS 2100','License withdrawn in 2003; MNC withdrawn'),
	 (10194,268,6,'National','Portugal','PT',172,'MEO','Telecomunicações Móveis Nacionais','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','formerly TMN (2014)'),
	 (10195,268,7,'National','Portugal','PT',172,'Vectone Mobile','Mundio Mobile (Portugal) Limited','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10196,268,11,'National','Portugal','PT',172,'','Compatel, Limited','Unknown','Unknown',''),
	 (10197,268,12,'National','Portugal','PT',172,'','Infraestruturas de Portugal, S.A.','Operational','GSM-R','former Refer Telecom, IP Telecom - Serviços de Telecomunicações, S.A.'),
	 (10198,268,13,'National','Portugal','PT',172,'','G9Telecom, S.A.','Unknown','Unknown',''),
	 (10199,268,21,'National','Portugal','PT',172,'Zapp','Zapp Portugal','Not operational','CDMA2000 450','Closed down in September 2011; MNC withdawn'),
	 (10200,268,80,'National','Portugal','PT',172,'MEO','Telecomunicações Móveis Nacionais','Unknown','Unknown',''),
	 (10201,330,0,'National','Puerto Rico','PR',173,'Open Mobile','PR Wireless','Operational','CDMA 1900',''),
	 (10202,330,110,'National','Puerto Rico','PR',173,'Claro Puerto Rico','América Móvil','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 700 / LTE 1700',''),
	 (10203,330,120,'National','Puerto Rico','PR',173,'Open Mobile','PR Wireless','Operational','LTE 700',''),
	 (10204,427,1,'National','Qatar','QA',174,'ooredoo','ooredoo','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Qtel (Qatar Telecom)'),
	 (10205,427,2,'National','Qatar','QA',174,'Vodafone','Vodafone Qatar','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10206,427,5,'National','Qatar','QA',174,'Ministry of Interior','Ministry of Interior','Operational','TETRA 380',''),
	 (10207,427,6,'National','Qatar','QA',174,'Ministry of Interior','Ministry of Interior','Operational','LTE',''),
	 (10208,226,1,'National','Romania','RO',176,'Vodafone','Vodafone România','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / TD-LTE 2600','Formerly branded as Connex'),
	 (10209,226,2,'National','Romania','RO',176,'Clicknet Mobile','Telekom Romania','Not operational','CDMA 420','Licence expired on 1 January 2015, and network was shut down'),
	 (10210,226,3,'National','Romania','RO',176,'Telekom','Telekom Romania','Operational','GSM 900 / GSM 1800 / LTE 800 / LTE 1800 / LTE 2600','Formerly branded as Cosmote'),
	 (10211,226,4,'National','Romania','RO',176,'Cosmote/Zapp','Telekom Romania','Not operational','CDMA 450','Licence expired on 24 March 2013, and network was shut down'),
	 (10212,226,5,'National','Romania','RO',176,'Digi.Mobil','RCS&RDS','Operational','UMTS 900 / UMTS 2100 / LTE 2100 / TD-LTE 2600',''),
	 (10213,226,6,'National','Romania','RO',176,'Telekom/Zapp','Telekom Romania','Operational','UMTS 900 / UMTS 2100','Branded as Telekom for data/voice and Zapp for data only'),
	 (10214,226,10,'National','Romania','RO',176,'Orange','Orange România','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Formerly branded as Dialog'),
	 (10215,226,11,'National','Romania','RO',176,'','Enigma-System','Unknown','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10216,226,15,'National','Romania','RO',176,'Idilis','Idilis','Operational','WiMAX / TD-LTE 2600','LTE license is sold to RCS&RDS, but both MNC(226 05 and 226 15) are broadcast by RCS&RDS for business continuity'),
	 (10217,226,16,'National','Romania','RO',176,'Lycamobile','Lycamobile Romania','Operational','MVNO','Uses Telekom Networks'),
	 (10218,250,1,'National','Russian Federation','RU',177,'MTS','Mobile TeleSystems','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600 / TD-LTE 2600',''),
	 (10219,250,2,'National','Russian Federation','RU',177,'MegaFon','MegaFon PJSC','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former North-West GSM'),
	 (10220,250,3,'National','Russian Federation','RU',177,'NCC','Nizhegorodskaya Cellular Communications','Operational','GSM 900 / GSM 1800','Purchased by Tele2'),
	 (10221,250,4,'National','Russian Federation','RU',177,'Sibchallenge','Sibchallenge','Not operational','GSM 900',''),
	 (10222,250,5,'National','Russian Federation','RU',177,'ETK','Yeniseytelecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / CDMA2000 450','Mobile Communications Systems'),
	 (10223,250,6,'National','Russian Federation','RU',177,'Skylink','CJSC Saratov System of Cellular Communications','Operational','CDMA2000 450',''),
	 (10224,250,7,'National','Russian Federation','RU',177,'SMARTS','Zao SMARTS','Operational','GSM 900 / GSM 1800',''),
	 (10225,250,8,'National','Russian Federation','RU',177,'Vainah Telecom','CS \"VainahTelecom\"','Operational','GSM 900 / GSM 1800 / LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10226,250,9,'National','Russian Federation','RU',177,'Skylink','Khabarovsky Cellular Phone','Operational','CDMA2000 450',''),
	 (10227,250,10,'National','Russian Federation','RU',177,'DTC','Dontelekom','Not operational','GSM 900',''),
	 (10228,250,11,'National','Russian Federation','RU',177,'Yota','Scartel','Operational','MVNO',''),
	 (10229,250,12,'National','Russian Federation','RU',177,'Baykalwestcom','Baykal Westcom / New Telephone Company / Far Eastern Cellular','Operational','GSM 900 / GSM 1800 / CDMA2000 450',''),
	 (10231,250,13,'National','Russian Federation','RU',177,'KUGSM','Kuban GSM','Not operational','GSM 900 / GSM 1800',''),
	 (10232,250,14,'National','Russian Federation','RU',177,'MegaFon','MegaFon OJSC','Not operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / TD-LTE 2600',''),
	 (10233,250,15,'National','Russian Federation','RU',177,'SMARTS','SMARTS Ufa, SMARTS Uljanovsk','Operational','GSM 1800',''),
	 (10234,250,16,'National','Russian Federation','RU',177,'NTC','New Telephone Company','Operational','GSM 900 / GSM 1800',''),
	 (10235,250,17,'National','Russian Federation','RU',177,'Utel','JSC Uralsvyazinform','Operational','GSM 900 / GSM 1800','Former Ermak RMS'),
	 (10236,250,18,'National','Russian Federation','RU',177,'Osnova Telecom','','Not operational','TD-LTE 2300','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10237,250,19,'National','Russian Federation','RU',177,'INDIGO','INDIGO','Not operational','GSM 1800','Since 19 December 2009 merged with Tele2'),
	 (10238,250,20,'National','Russian Federation','RU',177,'Tele2','Tele2','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 450 / LTE 1800 / LTE 2600',''),
	 (10239,250,21,'National','Russian Federation','RU',177,'GlobalTel','JSC \"GlobalTel\"','Operational','Satellite',''),
	 (10240,250,22,'National','Russian Federation','RU',177,'','Vainakh Telecom','Operational','TD-LTE 2300',''),
	 (10241,250,23,'National','Russian Federation','RU',177,'Thuraya','GTNT','Operational','Satellite MVNO','Former Mobicom Novosibirsk'),
	 (10242,250,28,'National','Russian Federation','RU',177,'Beeline','Beeline','Not operational','GSM 900','Former EXTEL'),
	 (10243,250,29,'National','Russian Federation','RU',177,'Iridium','Iridium Communications','Operational','Satellite MVNO',''),
	 (10244,250,32,'National','Russian Federation','RU',177,'Win Mobile','K-Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Operational in Crimea only.'),
	 (10245,250,33,'National','Russian Federation','RU',177,'Sevmobile','Sevtelekom','Operational','GSM 900 / GSM 1800 / UMTS 2100','Operational in Sevastopol only.'),
	 (10246,250,34,'National','Russian Federation','RU',177,'Krymtelekom','Krymtelekom','Operational','GSM 900 / GSM 1800 / UMTS 2100','Operational in Crimea only.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10247,250,35,'National','Russian Federation','RU',177,'MOTIV','EKATERINBURG-2000','Operational','GSM 1800 / LTE 1800',''),
	 (10248,250,38,'National','Russian Federation','RU',177,'Tambov GSM','Central Telecommunication Company','Operational','GSM 900 / GSM 1800',''),
	 (10249,250,39,'National','Russian Federation','RU',177,'Rostelecom','ROSTELECOM','Not operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / TD-LTE 2300 / LTE 2600','Tele2 code 250 20 is used since acquiring'),
	 (10250,250,44,'National','Russian Federation','RU',177,'','Stavtelesot / North Caucasian GSM','Not operational','Unknown',''),
	 (10251,250,50,'National','Russian Federation','RU',177,'MTS','Bezlimitno.ru','Operational','MVNO','Based on MTS'),
	 (10252,250,54,'National','Russian Federation','RU',177,'TTK','Tattelecom','Operational','LTE 1800',''),
	 (10253,250,60,'National','Russian Federation','RU',177,'Volna mobile','KTK Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Operational in Crimea only.'),
	 (10254,250,62,'National','Russian Federation','RU',177,'Tinkoff Mobile','Tinkoff Mobile','Operational','MVNO',''),
	 (10255,250,91,'National','Russian Federation','RU',177,'Sonic Duo','Sonic Duo CJSC','Not operational','GSM 1800',''),
	 (10256,250,92,'National','Russian Federation','RU',177,'','Primtelefon','Not operational','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10257,250,93,'National','Russian Federation','RU',177,'','Telecom XXI','Not operational','Unknown',''),
	 (10258,250,99,'National','Russian Federation','RU',177,'Beeline','OJSC Vimpel-Communications','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10259,250,0,'National','Russian Federation','RU',177,'SkyLink','SkyLink/MTS/the Moscow Cellular communication','Operational','CDMA2000 450',''),
	 (10260,250,811,'National','Russian Federation','RU',177,'','Votek Mobile','Not operational','AMPS / DAMPS / GSM 1800',''),
	 (10261,635,10,'National','Rwanda','RW',178,'MTN','MTN Rwandacell SARL','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100',''),
	 (10262,635,11,'National','Rwanda','RW',178,'Rwandatel','Rwandatel S.A.','Not operational','CDMA','Licence revoked in April 2011'),
	 (10263,635,12,'National','Rwanda','RW',178,'Rwandatel','Rwandatel S.A.','Not operational','GSM','Licence revoked in April 2011'),
	 (10264,635,13,'National','Rwanda','RW',178,'Tigo','TIGO RWANDA S.A','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10265,635,14,'National','Rwanda','RW',178,'Airtel','Airtel RWANDA','Operational','GSM 900 / GSM 1800 / UMTS 2100','Live since 1 April 2012'),
	 (10266,635,17,'National','Rwanda','RW',178,'Olleh','Olleh Rwanda Networks','Operational','LTE 800 / LTE 1800','LTE band 20 / 3; wholesale network used by Airtel, MTN, Tigo');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10267,658,1,'National','Saint Helena, Ascension and Tristan da Cunha','SH',179,'Sure','Sure South Atlantic Ltd.','Operational','GSM 900 / GSM 1800 / LTE 1800',''),
	 (10268,356,50,'National','Saint Kitts and Nevis','KN',180,'Digicel','Wireless Ventures (St Kitts-Nevis) Limited','Operational','GSM 900 / GSM 1800',''),
	 (10269,356,70,'National','Saint Kitts and Nevis','KN',180,'Chippie','UTS','Operational','',''),
	 (10270,356,110,'National','Saint Kitts and Nevis','KN',180,'FLOW','Cable & Wireless St. Kitts & Nevis Ltd','Operational','GSM 850 / GSM 1900 / LTE 700',''),
	 (10271,338,50,'National','Saint Lucia','LC',181,'Digicel','Digicel','Operational','GSM 900 / GSM 1800 / GSM 1900','uses Jamaica MCC'),
	 (10272,358,110,'National','Saint Lucia','LC',181,'FLOW','Cable & Wireless','Operational','GSM 850 / LTE 700',''),
	 (10273,308,1,'National','Saint Pierre and Miquelon (France)','PM',182,'Ameris','St. Pierre-et-Miquelon Télécom','Operational','GSM 900',''),
	 (10274,308,2,'National','Saint Pierre and Miquelon (France)','PM',182,'GLOBALTEL','GLOBALTEL','Operational','GSM 900',''),
	 (10275,360,50,'National','Saint Vincent and the Grenadines','VC',183,'Digicel','Digicel (St. Vincent and the Grenadines) Limited','Operational','GSM 900 / GSM 1800 / GSM 1900',''),
	 (10276,360,100,'National','Saint Vincent and the Grenadines','VC',183,'Cingular Wireless','','Unknown','GSM 850','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10277,360,110,'National','Saint Vincent and the Grenadines','VC',183,'FLOW','Cable & Wireless (St. Vincent & the Grenadines) Ltd','Operational','GSM 850',''),
	 (10278,549,0,'National','Samoa','WS',184,'Digicel','Digicel Pacific Ltd.','Unknown','Unknown',''),
	 (10279,549,1,'National','Samoa','WS',184,'Digicel','Digicel Pacific Ltd.','Operational','GSM 900 / UMTS 2100 / LTE 1800','Former Telecom Samoa Cellular Ltd.'),
	 (10280,549,27,'National','Samoa','WS',184,'Bluesky','Bluesky Samoa Ltd','Operational','GSM 900','Former Samoatel Ltd.'),
	 (10281,292,1,'National','San Marino','SM',185,'PRIMA','San Marino Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10282,626,1,'National','Sao Tome and Principe','ST',186,'CSTmovel','Companhia Santomese de Telecomunicaçôe','Operational','GSM 900',''),
	 (10283,626,2,'National','Sao Tome and Principe','ST',186,'Unitel STP','Unitel Sao Tome and Principe','Operational','GSM 900',''),
	 (10284,420,1,'National','Saudi Arabia','SA',187,'Al Jawal (STC )','Saudi Telecom Company','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100 / TD-LTE 2300',''),
	 (10285,420,3,'National','Saudi Arabia','SA',187,'Mobily','Etihad Etisalat Company','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / TD-LTE 2600',''),
	 (10286,420,4,'National','Saudi Arabia','SA',187,'Zain SA','Zain Saudi Arabia','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100 / TD-LTE 2600','Active September 2008');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10287,420,5,'National','Saudi Arabia','SA',187,'Virgin Mobile','Virgin Mobile Saudi Arabia','Operational','MVNO','Uses Al Jawal network'),
	 (10288,420,21,'National','Saudi Arabia','SA',187,'RGSM','Saudi Railways GSM','Operational','GSM-R 900',''),
	 (10289,608,1,'National','Senegal','SN',188,'Orange','Sonatel','Operational','GSM 900 / UMTS 2100 / LTE',''),
	 (10290,608,2,'National','Senegal','SN',188,'Tigo','Millicom International Cellular S.A.','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE','former SENTEL GSM'),
	 (10291,608,3,'National','Senegal','SN',188,'Expresso','Sudatel','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10292,608,4,'National','Senegal','SN',188,'','CSU-SA','Unknown','Unknown',''),
	 (10293,220,1,'National','Serbia','RS',240,'Telenor','Telenor Serbia','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800','Former MOBTEL'),
	 (10294,220,2,'National','Serbia','RS',240,'Telenor','Telenor Montenegro','Not operational','GSM 900 / GSM 1800 / UMTS 2100','Former ProMonte GSM; moved to MCC 297 MNC 01 (Montenegro) on 11 November 2011'),
	 (10295,220,3,'National','Serbia','RS',240,'mt:s','Telekom Srbija','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800 / TETRA',''),
	 (10296,220,4,'National','Serbia','RS',240,'T-Mobile','T-Mobile Montenegro LLC','Not operational','GSM','Former MoNet; moved to MCC 297 MNC 02 (Montenegro)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10297,220,5,'National','Serbia','RS',240,'VIP','VIP Mobile','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10298,220,7,'National','Serbia','RS',240,'','Orion Telekom','Operational','CDMA 450',''),
	 (10299,220,9,'National','Serbia','RS',240,'Vectone Mobile','MUNDIO MOBILE d.o.o.','Operational','MVNO','Uses VIP'),
	 (10300,220,11,'National','Serbia','RS',240,'GLOBALTEL','GLOBALTEL d.o.o.','Operational','MVNO','Uses VIP'),
	 (10301,633,1,'National','Seychelles','SC',190,'Cable & Wireless','Cable & Wireless Seychelles','Operational','GSM 900 / UMTS',''),
	 (10302,633,2,'National','Seychelles','SC',190,'Mediatech','Mediatech International','Not operational','GSM 1800','License and MNC withdrawn'),
	 (10303,633,10,'National','Seychelles','SC',190,'Airtel','Telecom Seychelles Ltd','Operational','GSM 900 / UMTS 2100 / LTE 800',''),
	 (10304,619,1,'National','Sierra Leone','SL',191,'Orange','Orange SL Limited','Operational','GSM 900 / UMTS 2100','Former Zain, Celtel, Bharti Airtel'),
	 (10305,619,2,'National','Sierra Leone','SL',191,'Africell','Lintel Sierra Leone Limited','Unknown','Unknown','Former Millicom, Tigo'),
	 (10306,619,3,'National','Sierra Leone','SL',191,'Africell','Lintel Sierra Leone Limited','Operational','GSM 900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10307,619,4,'National','Sierra Leone','SL',191,'Comium','Comium (Sierra Leone) Ltd.','Not operational','GSM 900 / GSM 1800',''),
	 (10308,619,5,'National','Sierra Leone','SL',191,'Africell','Lintel Sierra Leone Limited','Operational','GSM 900',''),
	 (10309,619,6,'National','Sierra Leone','SL',191,'SierraTel','Sierra Leone Telephony','Operational','CDMA 800 / LTE',''),
	 (10310,619,7,'National','Sierra Leone','SL',191,'','Qcell Sierra Leone','Unknown','Unknown',''),
	 (10311,619,9,'National','Sierra Leone','SL',191,'Smart Mobile','InterGroup Telecom SL','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10312,619,25,'National','Sierra Leone','SL',191,'Mobitel','Mobitel','Reserved','Unknown',''),
	 (10313,619,40,'National','Sierra Leone','SL',191,'','Datatel (SL) Ltd.','Unknown','GSM',''),
	 (10314,619,50,'National','Sierra Leone','SL',191,'','Datatel (SL) Ltd.','Unknown','CDMA',''),
	 (10315,525,1,'National','Singapore','SG',192,'SingTel','Singapore Telecom','Operational','UMTS 900 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2600','GSM shut down on 1 April 2017'),
	 (10316,525,2,'National','Singapore','SG',192,'SingTel-G18','Singapore Telecom','Not operational','GSM 1800','GSM shut down on 1 April 2017');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10317,525,3,'National','Singapore','SG',192,'M1','M1 Limited','Operational','UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600','GSM shut down on 1 April 2017'),
	 (10318,525,5,'National','Singapore','SG',192,'StarHub','StarHub Mobile','Operational','UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2600 / TD-LTE 2600','GSM shut down on 1 April 2017'),
	 (10319,525,6,'National','Singapore','SG',192,'StarHub','StarHub Mobile','Unknown','Unknown',''),
	 (10320,525,7,'National','Singapore','SG',192,'SingTel','Singapore Telecom','Unknown','Unknown',''),
	 (10321,525,8,'National','Singapore','SG',192,'StarHub','StarHub Mobile','Unknown','Unknown',''),
	 (10322,525,9,'National','Singapore','SG',192,'Circles.Life','Liberty Wireless Pte Ltd','Operational','MVNO',''),
	 (10323,525,10,'National','Singapore','SG',192,'TPG Telecom Pte Ltd	','TPG Telecom Pte Ltd','Unknown','Unknown',''),
	 (10324,525,12,'National','Singapore','SG',192,'Grid','GRID Communications Pte Ltd.','Operational','iDEN 800','Digital Trunked Radio Network'),
	 (10325,231,1,'National','Slovakia','SK',193,'Orange','Orange Slovensko','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 2600','Former Globtel'),
	 (10326,231,2,'National','Slovakia','SK',193,'Telekom','Slovak Telekom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Eurotel');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10327,231,3,'National','Slovakia','SK',193,'4ka','SWAN Mobile, a.s.','Operational','LTE 1800 / TD-LTE 3500 / TD-LTE 3700',''),
	 (10328,231,4,'National','Slovakia','SK',193,'Telekom','Slovak Telekom','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former T-Mobile'),
	 (10329,231,5,'National','Slovakia','SK',193,'Orange','Orange Slovensko','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100',''),
	 (10330,231,6,'National','Slovakia','SK',193,'O2','Telefónica O2 Slovakia','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / TD-LTE 3500 / TD-LTE 3700',''),
	 (10331,231,7,'National','Slovakia','SK',193,'','Towercom, a. s.','Unknown','Unknown',''),
	 (10332,231,8,'National','Slovakia','SK',193,'','IPfon, s.r.o.','Unknown','Unknown',''),
	 (10333,231,99,'National','Slovakia','SK',193,'ŽSR','Železnice Slovenskej Republiky','Operational','GSM-R','Railway communication and signalling'),
	 (10334,293,10,'National','Slovenia','SI',194,'','SŽ - Infrastruktura, d.o.o.','Operational','GSM-R',''),
	 (10335,293,20,'National','Slovenia','SI',194,'','COMPATEL Ltd','Unknown','Unknown',''),
	 (10336,293,40,'National','Slovenia','SI',194,'A1','A1 Slovenija','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Si.mobil');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10337,293,41,'National','Slovenia','SI',194,'Mobitel','Telekom Slovenije','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (10338,293,64,'National','Slovenia','SI',194,'T-2','T-2 d.o.o.','Operational','UMTS 2100',''),
	 (10339,293,70,'National','Slovenia','SI',194,'Telemach','Tušmobil d.o.o.','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10340,540,1,'National','Solomon Islands','SB',195,'BREEZE','Our Telekom','Operational','GSM 900 / UMTS / LTE 700 / LTE 1800','Former Solomon Telekom Co Ltd'),
	 (10341,540,2,'National','Solomon Islands','SB',195,'BeMobile','BMobile (SI) Ltd','Operational','GSM 900 / GSM 1800',''),
	 (10342,637,1,'National','Somalia','SO',196,'Telesom','Telesom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE',''),
	 (10343,637,4,'National','Somalia','SO',196,'Somafone','Somafone FZLLC','Operational','GSM 900 / GSM 1800',''),
	 (10344,637,10,'National','Somalia','SO',196,'Nationlink','NationLink Telecom','Operational','GSM 900',''),
	 (10345,637,20,'National','Somalia','SO',196,'SOMNET','SOMNET','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800','Uncertain bands'),
	 (10346,637,50,'National','Somalia','SO',196,'Hormuud','Hormuud Telecom Somalia Inc','Operational','GSM 900 / UMTS','Uncertain MNC number, maybe (also) 25');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10347,637,30,'National','Somalia','SO',196,'Golis','Golis Telecom Somalia','Operational','GSM 900',''),
	 (10348,637,57,'National','Somalia','SO',196,'UNITEL','UNITEL S.a.r.l.','Operational','GSM 900 / GSM 1800',''),
	 (10349,637,60,'National','Somalia','SO',196,'Nationlink','Nationlink Telecom','Operational','GSM 900 / GSM 1800',''),
	 (10350,637,67,'National','Somalia','SO',196,'Horntel Group','HTG Group Somalia','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10351,637,70,'National','Somalia','SO',196,'','Onkod Telecom Ltd.','Not operational','Unknown','MNC withdrawn'),
	 (10352,637,71,'National','Somalia','SO',196,'Somtel','Somtel','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800',''),
	 (10353,637,82,'National','Somalia','SO',196,'Telcom','Telcom Somalia','Operational','GSM 900 / GSM 1800 / CDMA2000 / LTE',''),
	 (10354,655,1,'National','South Africa','ZA',197,'Vodacom','Vodacom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100',''),
	 (10355,655,2,'National','South Africa','ZA',197,'Telkom','Telkom SA SOC Ltd','Operational','GSM 1800 / UMTS 2100 / LTE 1800 / TD-LTE 2300','Formerly Telkom Mobile, 8ta'),
	 (10356,655,4,'National','South Africa','ZA',197,'','Sasol (Pty) Ltd.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10357,655,5,'National','South Africa','ZA',197,'','Telkom SA Ltd','Unknown','Unknown',''),
	 (10358,655,6,'National','South Africa','ZA',197,'','Sentech (Pty) Ltd','Operational','Unknown',''),
	 (10359,655,7,'National','South Africa','ZA',197,'Cell C','Cell C (Pty) Ltd','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 1800 / LTE 2100',''),
	 (10360,655,10,'National','South Africa','ZA',197,'MTN','MTN Group','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (10361,655,11,'National','South Africa','ZA',197,'','South African Police Service Gauteng','Operational','TETRA 410',''),
	 (10362,655,12,'National','South Africa','ZA',197,'MTN','MTN Group','Unknown','Unknown',''),
	 (10363,655,13,'National','South Africa','ZA',197,'Neotel','Neotel Pty Ltd','Operational','CDMA 800',''),
	 (10364,655,14,'National','South Africa','ZA',197,'Neotel','Neotel Pty Ltd','Operational','LTE 1800',''),
	 (10365,655,16,'National','South Africa','ZA',197,'','Phoenix System Integration (Pty) Ltd','Not operational','Unknown','MNC withdrawn'),
	 (10366,655,17,'National','South Africa','ZA',197,'','Sishen Iron Ore Company (Ltd) Pty','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10367,655,19,'National','South Africa','ZA',197,'','Wireless Business Solutions (Pty) Ltd','Operational','TD-LTE','LTE 2600 trial'),
	 (10368,655,21,'National','South Africa','ZA',197,'','Cape Town Metropolitan Council','Operational','TETRA 410',''),
	 (10369,655,24,'National','South Africa','ZA',197,'','SMSPortal (Pty) Ltd.','Unknown','Unknown',''),
	 (10370,655,25,'National','South Africa','ZA',197,'','Wirels Connect','Unknown','Unknown',''),
	 (10371,655,27,'National','South Africa','ZA',197,'','A to Z Vaal Industrial Supplies Pty Ltd','Unknown','Unknown',''),
	 (10372,655,28,'National','South Africa','ZA',197,'','Hymax Talking Solutions (Pty) Ltd','Unknown','Unknown',''),
	 (10373,655,30,'National','South Africa','ZA',197,'','Bokamoso Consortium','Operational','Unknown',''),
	 (10374,655,31,'National','South Africa','ZA',197,'','Karabo Telecoms (Pty) Ltd.','Operational','Unknown',''),
	 (10375,655,32,'National','South Africa','ZA',197,'','Ilizwi Telecommunications','Operational','Unknown',''),
	 (10376,655,33,'National','South Africa','ZA',197,'','Thinta Thinta Telecommunications Pty Ltd','Operational','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10377,655,34,'National','South Africa','ZA',197,'','Bokone Telecoms Pty Ltd','Unknown','Unknown',''),
	 (10378,655,35,'National','South Africa','ZA',197,'','Kingdom Communications Pty Ltd','Unknown','Unknown',''),
	 (10379,655,36,'National','South Africa','ZA',197,'','Amatole Telecommunications Pty Ltd','Unknown','Unknown',''),
	 (10380,655,38,'National','South Africa','ZA',197,'iBurst','Wireless Business Solutions (Pty) Ltd','Unknown','Unknown',''),
	 (10381,655,41,'National','South Africa','ZA',197,'','South African Police Service','Unknown','Unknown',''),
	 (10382,655,46,'National','South Africa','ZA',197,'','SMS Cellular Services (Pty) Ltd','Operational','MVNO',''),
	 (10383,655,50,'National','South Africa','ZA',197,'','Ericsson South Africa (Pty) Ltd','Unknown','Unknown',''),
	 (10384,655,51,'National','South Africa','ZA',197,'','Integrat (Pty) Ltd','Unknown','Unknown',''),
	 (10385,655,53,'National','South Africa','ZA',197,'Lycamobile','Lycamobile (Pty) Ltd','Unknown','MVNO',''),
	 (10386,655,73,'National','South Africa','ZA',197,'iBurst','Wireless Business Solutions (Pty) Ltd','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10387,655,74,'National','South Africa','ZA',197,'iBurst','Wireless Business Solutions (Pty) Ltd','Unknown','Unknown',''),
	 (10388,655,75,'National','South Africa','ZA',197,'ACSA','Airports Company South Africa','Unknown','Unknown',''),
	 (10389,659,2,'National','South Sudan','SS',253,'MTN','MTN South Sudan','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10390,659,3,'National','South Sudan','SS',253,'Gemtel','Gemtel','Operational','GSM 900 / GSM 1800',''),
	 (10391,659,4,'National','South Sudan','SS',253,'Vivacell','Network of the World (NOW)','Operational','GSM 900 / GSM 1800',''),
	 (10392,659,6,'National','South Sudan','SS',253,'Zain','Zain South Sudan','Operational','GSM 900 / GSM 1800',''),
	 (10393,659,7,'National','South Sudan','SS',253,'Sudani','Sudani','Operational','CDMA',''),
	 (10394,214,1,'National','Spain','ES',199,'Vodafone','Vodafone Spain','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600 / TD-LTE 2600','Also use MNC 19 and also 15 Some MVNO use this MNC (Hits, Eroski, Lebara, PepePhone)'),
	 (10395,214,2,'National','Spain','ES',199,'Altecom/Fibracat','Alta Tecnologia en Comunicacions SL','Operational','TD-LTE 2600','Some MVNO use this MNC (Fibracat, Aircom, Anxanet, Netports)'),
	 (10396,214,3,'National','Spain','ES',199,'Orange','France Telecom España SA','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Also use MNC 33 Some MVNO use this MNC (CarrefourOnline, Dia, Hualong, Llamaya, MasMovil, The Phone House Spain, CABLE movil, SUOP)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10397,214,4,'National','Spain','ES',199,'Yoigo','Xfera Moviles SA','Operational','GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (10398,214,5,'National','Spain','ES',199,'Movistar','Telefónica Móviles España','Operational','GSM 900 / GSM 1800 / UMTS 2100','Used by MVNOs.'),
	 (10399,214,6,'National','Spain','ES',199,'Vodafone','Vodafone Spain','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Used by resellers (e.g. Vodafone''s own low cost virtual operator, Lowi)/Also use MNC 19'),
	 (10400,214,7,'National','Spain','ES',199,'Movistar','Telefónica Móviles España','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Some MVNO use this MNC (Tu, Sweno, Vectone Movil, ZeroMovil)'),
	 (10401,214,8,'National','Spain','ES',199,'Euskaltel','','Operational','MVNO','Some MVNO use this MNC (RACC)'),
	 (10402,214,9,'National','Spain','ES',199,'Orange','France Telecom España SA','Operational','GSM 900 / GSM 1800 / UMTS 2100','Used by resellers'),
	 (10403,214,10,'National','Spain','ES',199,'','ZINNIA TELECOMUNICACIONES, S.L.U.','Unknown','Unknown','Former Operadora de Telecomunicaciones Opera SL'),
	 (10404,214,11,'National','Spain','ES',199,'','TELECOM CASTILLA-LA MANCHA, S.A.','Unknown','Unknown','Former Orange (France Telecom España SA)'),
	 (10405,214,12,'National','Spain','ES',199,'','Contacta Servicios Avanzados de Telecomunicaciones SL','Not operational','Unknown','MNC withdrawn'),
	 (10406,214,13,'National','Spain','ES',199,'','Incotel Ingeniera y Consultaria SL','Not operational','Unknown','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10407,214,14,'National','Spain','ES',199,'','Incotel Servicioz Avanzados SL','Not operational','Unknown','MNC withdrawn'),
	 (10408,214,15,'National','Spain','ES',199,'BT','BT Group España Compañia de Servicios Globales de Telecomunicaciones S.A.U.','Not operational','MVNO','MNC withdrawn'),
	 (10409,214,16,'National','Spain','ES',199,'TeleCable','Telecable de Asturias S.A.U.','Operational','MVNO',''),
	 (10410,214,17,'National','Spain','ES',199,'Móbil R','R Cable y Telecomunicaciones Galicia S.A.','Operational','MVNO',''),
	 (10411,214,18,'National','Spain','ES',199,'ONO','Cableuropa S.A.U.','Not operational','MVNO','MNC withdrawn; acquired by Vodafone'),
	 (10412,214,19,'National','Spain','ES',199,'Simyo','E-PLUS Moviles Virtuales España S.L.U.','Operational','MVNO',''),
	 (10413,214,20,'National','Spain','ES',199,'Fonyou','Fonyou Telecom S.L.','Not operational','MVNO','MNC withdrawn'),
	 (10414,214,21,'National','Spain','ES',199,'Jazztel','Orange S.A.','Operational','MVNO','Acquired by Orange in 2014'),
	 (10415,214,22,'National','Spain','ES',199,'DigiMobil','Best Spain Telecom','Operational','MVNO',''),
	 (10416,214,23,'National','Spain','ES',199,'Barablu','Barablu Móvil España','Unknown','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10417,214,24,'National','Spain','ES',199,'Eroski','Eroski Móvil España','Operational','MVNO','Also use MNC 01. Some MVNO use this MNC (Orbitel, Vizzavi)'),
	 (10418,214,25,'National','Spain','ES',199,'Lycamobile','LycaMobile S.L.','Operational','MVNO',''),
	 (10419,214,26,'National','Spain','ES',199,'','Lleida Networks Serveis Telemátics, SL','Unknown','Unknown',''),
	 (10420,214,27,'National','Spain','ES',199,'Truphone','SCN Truphone, S.L.','Operational','MVNO',''),
	 (10421,214,28,'National','Spain','ES',199,'Murcia4G','Consorcio de Telecomunicaciones Avanzadas, S.A.','Operational','TD-LTE 2600','LTE band 38'),
	 (10422,214,29,'National','Spain','ES',199,'','NEO-SKY 2002, S.A.','Operational','TD-LTE 3500',''),
	 (10423,214,30,'National','Spain','ES',199,'','Compatel Limited','Unknown','Unknown',''),
	 (10424,214,31,'National','Spain','ES',199,'','Red Digital De Telecomunicaciones de las Islas Baleares, S.L.','Unknown','Unknown',''),
	 (10425,214,32,'National','Spain','ES',199,'Tuenti','Telefónica Móviles España','Operational','MVNO',''),
	 (10426,214,33,'National','Spain','ES',199,'','EURONA WIRELESS TELECOM, S.A.','Operational','WiMAX','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10427,214,34,'National','Spain','ES',199,'','Aire Networks del Mediterráneo, S.L.U.','Operational','LTE 2600',''),
	 (10428,214,35,'National','Spain','ES',199,'','INGENIUM OUTSOURCING SERVICES, S.L.','Unknown','MVNO',''),
	 (10429,214,36,'National','Spain','ES',199,'','OPEN CABLE TELECOMUNICACIONES, S.L.','Unknown','Unknown',''),
	 (10430,214,51,'National','Spain','ES',199,'ADIF','Administrador de Infraestructuras Ferroviarias','Operational','GSM-R',''),
	 (10431,413,1,'National','Sri Lanka','LK',200,'Mobitel','Mobitel (Pvt) Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100',''),
	 (10432,413,2,'National','Sri Lanka','LK',200,'Dialog','Dialog Axiata PLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800','Former MTN'),
	 (10433,413,3,'National','Sri Lanka','LK',200,'Etisalat','Etisalat Lanka (Pvt) Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Tigo / Celltel'),
	 (10434,413,4,'National','Sri Lanka','LK',200,'Lanka Bell','Lanka Bell Ltd','Operational','CDMA / WiMAX / TD-LTE 2300',''),
	 (10435,413,5,'National','Sri Lanka','LK',200,'Airtel','Bharti Airtel Lanka (Pvt) Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10436,413,8,'National','Sri Lanka','LK',200,'Hutch','Hutchison Telecommunications Lanka (Pvt) Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10437,413,11,'National','Sri Lanka','LK',200,'Dialog','Dialog Broadband Networks (Pvt) Ltd','Operational','CDMA / WiMAX / TD-LTE 2300',''),
	 (10438,413,12,'National','Sri Lanka','LK',200,'SLT','Sri Lanka Telecom PLC','Operational','CDMA / TD-LTE 2600',''),
	 (10439,413,13,'National','Sri Lanka','LK',200,'Lanka Bell','Lanka Bell Ltd','Operational','TD-LTE 2300',''),
	 (10440,634,1,'National','Sudan','SD',201,'Zain SD','Zain Group - Sudan','Operational','GSM 900 / UMTS 2100 / LTE 1800','Former, Mobitel'),
	 (10441,634,2,'National','Sudan','SD',201,'MTN','MTN Sudan','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10442,634,3,'National','Sudan','SD',201,'MTN','MTN Sudan','Unknown','Unknown',''),
	 (10443,634,5,'National','Sudan','SD',201,'canar','Canar Telecom','Operational','CDMA2000 450',''),
	 (10444,634,7,'National','Sudan','SD',201,'Sudani One','Sudatel Group','Operational','GSM 1800 / UMTS 2100 / LTE 1800 / CDMA2000 800',''),
	 (10445,634,9,'National','Sudan','SD',201,'Privet Network','NEC','Unknown','',''),
	 (10446,746,2,'National','Suriname','SR',202,'Telesur','Telecommunications Company Suriname (Telesur)','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 700 / LTE 1800','LTE bands 28, 3');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10447,746,3,'National','Suriname','SR',202,'Digicel','Digicel Group Limited','Operational','GSM 900 / GSM 1800 / UMTS 850',''),
	 (10448,746,4,'National','Suriname','SR',202,'Digicel','Digicel Group Limited','Not operational','GSM 900 / UMTS','Former Uniqa (Intelsur N.V. / UTS N.V.); MNC withdrawn'),
	 (10449,746,5,'National','Suriname','SR',202,'Telesur','Telecommunications Company Suriname (Telesur)','Unknown','CDMA 450',''),
	 (10450,653,1,'National','Swaziland','SZ',204,'','SPTC','Unknown','Unknown',''),
	 (10451,653,2,'National','Swaziland','SZ',204,'Swazi Mobile','Swazi Mobile Limited','Operational','Unknown',''),
	 (10452,653,10,'National','Swaziland','SZ',204,'Swazi MTN','Swazi MTN Limited','Operational','GSM 900',''),
	 (10453,240,1,'National','Sweden','SE',205,'Telia','TeliaSonera Sverige AB','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10454,240,2,'National','Sweden','SE',205,'3','HI3G Access AB','Operational','UMTS 900 / UMTS 2100 / LTE 800 / LTE 2600 / TD-LTE 2600',''),
	 (10455,240,3,'National','Sweden','SE',205,'Net 1','Netett Sverige AB','Operational','LTE 450','Former Ice.net; CDMA 450 shut down'),
	 (10456,240,4,'National','Sweden','SE',205,'SWEDEN','3G Infrastructure Services AB','Operational','UMTS 2100','Owned by Hi3G Access (3) and Telenor. Not available in major cities since the owners operate their own city networks.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10457,240,5,'National','Sweden','SE',205,'Sweden 3G','Svenska UMTS-Nät AB','Operational','UMTS 2100','Owned by Telia and Tele2. Available all over Sweden.'),
	 (10458,240,6,'National','Sweden','SE',205,'Telenor','Telenor Sverige AB','Operational','UMTS 2100','former Vodafone Sweden'),
	 (10459,240,7,'National','Sweden','SE',205,'Tele2','Tele2 Sverige AB','Operational','UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2600','MOCN r6 network'),
	 (10460,240,8,'National','Sweden','SE',205,'Telenor','Telenor Sverige AB','Not operational','GSM 900 / GSM 1800','Now merged with Tele2 into Net4Mobility'),
	 (10461,240,9,'National','Sweden','SE',205,'Com4','Communication for Devices in Sweden AB','Unknown','Unknown','former djuice (Telenor MVNO)'),
	 (10462,240,10,'National','Sweden','SE',205,'Spring Mobil','Tele2 Sverige AB','Operational','','Only used on femto- and nanocells'),
	 (10463,240,11,'National','Sweden','SE',205,'','ComHem AB','Unknown','Unknown','Former Lindholmen Science Park AB'),
	 (10464,240,12,'National','Sweden','SE',205,'Lycamobile','Lycamobile Sweden Limited','Operational','MVNO',''),
	 (10465,240,13,'National','Sweden','SE',205,'','Alltele Företag Sverige AB','Unknown','Unknown',''),
	 (10466,240,14,'National','Sweden','SE',205,'','Tele2 Business AB','Unknown','Unknown','Former TDC Sverige AB (MVNO)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10467,240,15,'National','Sweden','SE',205,'','Wireless Maingate Nordic AB','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10468,240,16,'National','Sweden','SE',205,'','42 Telecom AB','Operational','GSM',''),
	 (10469,240,17,'National','Sweden','SE',205,'Gotanet','Götalandsnätet AB','Operational','MVNO',''),
	 (10470,240,18,'National','Sweden','SE',205,'','Generic Mobile Systems Sweden AB','Unknown','Unknown',''),
	 (10471,240,19,'National','Sweden','SE',205,'Vectone Mobile','Mundio Mobile (Sweden) Limited','Operational','MVNO','MVNO in Telia''s network'),
	 (10472,240,20,'National','Sweden','SE',205,'','Wireless Maingate Messaging Services AB','Operational','GSM',''),
	 (10473,240,21,'National','Sweden','SE',205,'MobiSir','Trafikverket ICT','Operational','GSM-R 900',''),
	 (10474,240,22,'National','Sweden','SE',205,'','EuTel AB','Unknown','Unknown',''),
	 (10475,240,23,'National','Sweden','SE',205,'','Infobip Limited (UK)','Not operational','Unknown',''),
	 (10476,240,24,'National','Sweden','SE',205,'Sweden 2G','Net4Mobility HB','Operational','GSM 900 / LTE 800 / LTE 900 / LTE 1800 / LTE 2600','LTE1800 only available in major cities, it was deployed mostly to boost sales of the iPhone 5; owned by Telenor and Tele2.');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10477,240,25,'National','Sweden','SE',205,'','Monty UK Global Ltd','Unknown','Unknown','Former Digitel Mobile Srl'),
	 (10478,240,26,'National','Sweden','SE',205,'','Twilio Sweden AB','Unknown','Unknown','Former Beepsend AB'),
	 (10479,240,27,'National','Sweden','SE',205,'','GlobeTouch AB','Operational','MVNO','Former Fogg Mobile AB; M2M services only'),
	 (10480,240,28,'National','Sweden','SE',205,'','LINK Mobile A/S','Unknown','Unknown','Former CoolTEL Aps'),
	 (10481,240,29,'National','Sweden','SE',205,'','Mercury International Carrier Services','Unknown','Unknown',''),
	 (10482,240,30,'National','Sweden','SE',205,'','NextGen Mobile Ltd.','Unknown','Unknown',''),
	 (10483,240,31,'National','Sweden','SE',205,'','RebTel Network AB','Unknown','Unknown','Former Mobimax AB'),
	 (10484,240,32,'National','Sweden','SE',205,'','Compatel Limited','Unknown','Unknown',''),
	 (10485,240,33,'National','Sweden','SE',205,'','Mobile Arts AB','Unknown','Unknown',''),
	 (10486,240,34,'National','Sweden','SE',205,'','Pro Net Telecommunications Services Ltd.','Not operational','Unknown','Formerly Tigo; MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10487,240,35,'National','Sweden','SE',205,'','42 Telecom LTD','Unknown','Unknown',''),
	 (10488,240,36,'National','Sweden','SE',205,'','interactive digital media GmbH','Unknown','Unknown',''),
	 (10489,240,37,'National','Sweden','SE',205,'','CLX Networks AB','Operational','Unknown',''),
	 (10490,240,38,'National','Sweden','SE',205,'Voxbone','Voxbone mobile','Operational','MVNO',''),
	 (10491,240,39,'National','Sweden','SE',205,'','Borderlight AB','Unknown','Unknown','Former iCentrex Sweden AB'),
	 (10492,240,40,'National','Sweden','SE',205,'','North net connect AB','Unknown','Unknown','Former ReWiCom Scandinavia AB'),
	 (10493,240,41,'National','Sweden','SE',205,'','Shyam Telecom UK Ltd.','Unknown','Unknown',''),
	 (10494,240,42,'National','Sweden','SE',205,'','Telenor Connexion AB','Unknown','Unknown',''),
	 (10495,240,43,'National','Sweden','SE',205,'','MobiWeb Ltd.','Unknown','Unknown',''),
	 (10496,240,44,'National','Sweden','SE',205,'','Telenabler AB','Unknown','Unknown','Former Limitless Mobile AB');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10497,240,45,'National','Sweden','SE',205,'','Spirius AB','Unknown','Unknown',''),
	 (10498,240,46,'National','Sweden','SE',205,'Viahub','SMS Provider Corp.','Unknown','MVNO',''),
	 (10499,240,47,'National','Sweden','SE',205,'','Viatel Sweden AB','Unknown','Unknown',''),
	 (10500,240,60,'National','Sweden','SE',205,'','Telefonaktiebolaget LM Ericsson','Unknown','Unknown','Test network; Temporary license until 31 December 2018'),
	 (10501,240,61,'National','Sweden','SE',205,'','MessageBird B.V.','Unknown','Unknown',''),
	 (10502,228,1,'National','Switzerland','CH',206,'Swisscom','Swisscom AG','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','GSM shutdown planned for 2020'),
	 (10503,228,2,'National','Switzerland','CH',206,'Sunrise','Sunrise Communications AG','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10504,228,3,'National','Switzerland','CH',206,'Salt','Salt Mobile SA','Operational','GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Orange'),
	 (10505,228,5,'National','Switzerland','CH',206,'','Comfone AG','Not operational','Unknown','Former Togewanet AG'),
	 (10506,228,6,'National','Switzerland','CH',206,'SBB-CFF-FFS','SBB AG','Operational','GSM-R 900','railways communication');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10507,228,7,'National','Switzerland','CH',206,'IN&Phone','IN&Phone SA','Not operational','GSM 1800','MNC withdrawn, bankrupt in 2012'),
	 (10508,228,8,'National','Switzerland','CH',206,'Tele4u','TelCommunication Services AG','Operational','GSM 1800','owned by Sunrise, former Tele2'),
	 (10509,228,9,'National','Switzerland','CH',206,'','Comfone AG','Unknown','Unknown',''),
	 (10510,228,11,'National','Switzerland','CH',206,'','Swisscom Broadcast AG','Unknown','Unknown',''),
	 (10511,228,12,'National','Switzerland','CH',206,'Sunrise','Sunrise Communications AG','Not operational','',''),
	 (10512,228,50,'National','Switzerland','CH',206,'','3G Mobile AG','Not operational','UMTS 2100','MNC withdrawn'),
	 (10513,228,51,'National','Switzerland','CH',206,'','relario AG','Operational','MVNO','Former BebbiCell AG'),
	 (10514,228,52,'National','Switzerland','CH',206,'Barablu','Barablu','Not operational','','MNC withdrawn'),
	 (10515,228,53,'National','Switzerland','CH',206,'upc cablecom','UPC Schweiz GmbH','Operational','MVNO',''),
	 (10516,228,54,'National','Switzerland','CH',206,'Lycamobile','Lycamobile AG','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10517,228,55,'National','Switzerland','CH',206,'','WeMobile SA','Unknown','','SMS relay only'),
	 (10518,228,56,'National','Switzerland','CH',206,'','SMSRelay AG','Not operational','Unknown','MNC withdrawn'),
	 (10519,228,57,'National','Switzerland','CH',206,'','Mitto AG','Unknown','','SMS relay only'),
	 (10520,228,58,'National','Switzerland','CH',206,'beeone','Beeone Communications SA','Operational','MVNO',''),
	 (10521,228,59,'National','Switzerland','CH',206,'Vectone','Mundio Mobile Limited','Not operational','MVNO','MNC withdrawn'),
	 (10522,228,60,'National','Switzerland','CH',206,'Sunrise','Sunrise Communications AG','Not operational','Unknown','Network sharing test with Salt Mobile; MNC withdrawn'),
	 (10523,228,61,'National','Switzerland','CH',206,'','Compatel Ltd.','Unknown','','SMS relay only'),
	 (10524,228,99,'National','Switzerland','CH',206,'','Swisscom Broadcast AG','Unknown','','Test network'),
	 (10525,417,1,'National','Syria','SY',207,'Syriatel','Syriatel Mobile Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10526,417,2,'National','Syria','SY',207,'MTN','MTN Syria','Operational','GSM 900 / GSM 1800 / UMTS 2100','Former Spacetel');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10527,417,9,'National','Syria','SY',207,'','Syrian Telecom','Unknown','Unknown',''),
	 (10528,466,1,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 700 / LTE 1800 / LTE 2600','LTE band 28'),
	 (10529,466,2,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Unknown','GSM 900',''),
	 (10530,466,3,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Unknown','UMTS 2100',''),
	 (10531,466,5,'National','Taiwan','TW',208,'APTG','Asia Pacific Telecom','Operational','LTE 700','LTE band 28; CDMA 850MHz shut down Dec 2017'),
	 (10532,466,6,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Operational','GSM 1800','Former KG Telecom until 2004'),
	 (10533,466,7,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Not operational','WiMAX 2600','Shut down in 2015'),
	 (10534,466,9,'National','Taiwan','TW',208,'VMAX','Vmax Telecom','Operational','WiMAX 2600',''),
	 (10535,466,10,'National','Taiwan','TW',208,'G1','Global Mobile Corp.','Operational','WiMAX 2600',''),
	 (10536,466,11,'National','Taiwan','TW',208,'Chunghwa LDM','LDTA/Chunghwa Telecom','Operational','GSM 1800','Also known as \"Long Distance & Mobile Business Group\"');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10537,466,12,'National','Taiwan','TW',208,'','Ambit Microsystems','Operational','LTE 700 / LTE 900','Subsidiary of Foxconn; LTE band 28'),
	 (10538,466,56,'National','Taiwan','TW',208,'FITEL','First International Telecom','Not operational','WiMAX 2600 / PHS','Bankruptcy in 2014'),
	 (10539,466,68,'National','Taiwan','TW',208,'','Tatung InfoComm','Not operational','WiMAX 2600','License expired in 2014'),
	 (10540,466,88,'National','Taiwan','TW',208,'FarEasTone','Far EasTone Telecommunications Co Ltd','Operational','GSM 1800','Former KG Telecom until 2004, KG Telecom brand used until 2009'),
	 (10541,466,89,'National','Taiwan','TW',208,'T Star','Taiwan Star Telecom','Operational','UMTS 2100 / LTE 900 / LTE 2600',''),
	 (10542,466,90,'National','Taiwan','TW',208,'T Star','Taiwan Star Telecom','Unknown','LTE 900',''),
	 (10543,466,92,'National','Taiwan','TW',208,'Chunghwa','Chunghwa Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 900 / LTE 1800 / LTE 2600',''),
	 (10544,466,93,'National','Taiwan','TW',208,'MobiTai','Mobitai Communications','Not operational','GSM 900','Acquired by Taiwan Mobile in 2004, MobiTai brand used until 2008'),
	 (10545,466,97,'National','Taiwan','TW',208,'Taiwan Mobile','Taiwan Mobile Co. Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 700 / LTE 1800','LTE band 28'),
	 (10546,466,99,'National','Taiwan','TW',208,'TransAsia','TransAsia Telecoms','Not operational','GSM 900','Acquired by Taiwan Mobile in 2002, TransAsia brand used until 2008');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10547,436,1,'National','Tajikistan','TJ',209,'Tcell','JV Somoncom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800',''),
	 (10548,436,2,'National','Tajikistan','TJ',209,'Tcell','Indigo Tajikistan','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800',''),
	 (10549,436,3,'National','Tajikistan','TJ',209,'MegaFon','TT Mobile','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800',''),
	 (10550,436,4,'National','Tajikistan','TJ',209,'Babilon-M','Babilon-Mobile','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800 / LTE 2100',''),
	 (10551,436,5,'National','Tajikistan','TJ',209,'Beeline','Tacom','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10552,436,10,'National','Tajikistan','TJ',209,'Babilon-T','Babilon-T','Operational','TD-LTE 2300 / WiMAX',''),
	 (10553,436,12,'National','Tajikistan','TJ',209,'Tcell','Indigo','Unknown','UMTS 2100',''),
	 (10554,640,1,'National','Tanzania','TZ',210,'','Rural NetCo Limited','Not operational','UMTS 900','MNC withdrawn'),
	 (10555,640,2,'National','Tanzania','TZ',210,'tiGO','MIC Tanzania Limited','Operational','GSM 900 / GSM 1800 / LTE 800','Former Mobitel and Buzz'),
	 (10556,640,3,'National','Tanzania','TZ',210,'Zantel','Zanzibar Telecom Ltd','Operational','GSM 900 / GSM 1800 / LTE 1800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10557,640,4,'National','Tanzania','TZ',210,'Vodacom','Vodacom Tanzania Limited','Operational','GSM 900 / GSM 1800 / LTE 1800',''),
	 (10558,640,5,'National','Tanzania','TZ',210,'Airtel','Bharti Airtel','Operational','GSM 900 / GSM 1800','Former Celtel (Zain)'),
	 (10559,640,6,'National','Tanzania','TZ',210,'Sasatel (Dovetel)','Dovetel Limited','Not operational','CDMA 800','MNC withdrawn'),
	 (10560,640,7,'National','Tanzania','TZ',210,'TTCL Mobile','Tanzania Telecommunication Company LTD (TTCL)','Operational','CDMA 800 / LTE 1800 / TD-LTE 2300',''),
	 (10561,640,8,'National','Tanzania','TZ',210,'Smart','Benson Informatics Limited','Operational','TD-LTE 2300',''),
	 (10562,640,9,'National','Tanzania','TZ',210,'Halotel','Viettel Tanzania Limited','Operational','GSM 900 / GSM 1800','Former ExcellentCom Tanzania Limited (Hits)'),
	 (10563,640,11,'National','Tanzania','TZ',210,'SmileCom','Smile Telecoms Holdings Ltd.','Operational','LTE 800',''),
	 (10564,640,12,'National','Tanzania','TZ',210,'','MyCell Limited','Not operational','Unknown','MNC withdrawn'),
	 (10565,640,13,'National','Tanzania','TZ',210,'Cootel','Wiafrica Tanzania Limited','Unknown','Unknown',''),
	 (10566,520,0,'National','Thailand','TH',211,'TrueMove H & my by CAT','CAT Telecom','Operational','UMTS 850','Former Hutch Thailand; inbound roaming for TrueMove H');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10567,520,1,'National','Thailand','TH',211,'AIS','Advanced Info Service','Not operational','GSM 900 / UMTS 900','UMTS 900 shut down in 2013; GSM 900 shut down in February 2016'),
	 (10568,520,2,'National','Thailand','TH',211,'CAT CDMA','CAT Telecom','Not operational','CDMA 800','Network shut down in April 2013; frequency re-farmed for UMTS 850 network 520-00'),
	 (10569,520,3,'National','Thailand','TH',211,'AIS','Advanced Wireless Network Company Ltd.','Operational','UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100',''),
	 (10570,520,4,'National','Thailand','TH',211,'TrueMove H','True Move H Universal Communication Company Ltd.','Operational','UMTS 2100 / LTE 900 / LTE 1800 / LTE 2100','UMTS roaming with network 520-00'),
	 (10571,520,5,'National','Thailand','TH',211,'dtac TriNet','DTAC Network Company Ltd.','Operational','UMTS 850 / UMTS 2100 / LTE 1800 / LTE 2100','GSM roaming with network 520-18'),
	 (10572,520,15,'National','Thailand','TH',211,'TOT 3G','TOT Public Company Limited','Operational','UMTS 2100 / TD-LTE 2300','Former Thaimobile 1900, ACT Mobile'),
	 (10573,520,18,'National','Thailand','TH',211,'dtac','Total Access Communications Public Company Ltd.','Operational','GSM 1800','GSM 1800 to shut down in 2018'),
	 (10574,520,20,'National','Thailand','TH',211,'ACeS','ACeS','Unknown','Satellite',''),
	 (10575,520,23,'National','Thailand','TH',211,'AIS GSM 1800','Digital Phone Company Ltd.','Not operational','GSM 1800','Owned by AIS; network shut down in January 2016'),
	 (10576,520,25,'National','Thailand','TH',211,'WE PCT','True Corporation','Not operational','PHS 1900','In Bangkok area');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10577,520,47,'National','Thailand','TH',211,'','Telephone Organization of Thailand (TOT)','Unknown','Unknown',''),
	 (10578,520,90,'National','Thailand','TH',211,'','Royal Thai Police','Operational','LTE 850','LTE band 26'),
	 (10579,520,99,'National','Thailand','TH',211,'TrueMove','True Corporation','Not operational','GSM 1800','Network shut down in January 2016'),
	 (10580,615,1,'National','Togo','TG',213,'Togo Cell','Togo Telecom','Operational','GSM 900',''),
	 (10581,615,3,'National','Togo','TG',213,'Moov','Moov Togo','Operational','GSM 900',''),
	 (10582,554,1,'National','Tokelau','TK',214,'','Teletok','Operational','LTE 700',''),
	 (10583,539,1,'National','Tonga','TO',215,'U-Call','Tonga Communications Corporation','Operational','GSM 900',''),
	 (10584,539,43,'National','Tonga','TO',215,'','Shoreline Communication','Operational','Unknown',''),
	 (10585,539,88,'National','Tonga','TO',215,'Digicel','Digicel (Tonga) Limited','Operational','GSM 900 / LTE 1800',''),
	 (10586,374,12,'National','Trinidad and Tobago','TT',216,'bmobile','TSTT','Operational','GSM 850 / GSM 1900 / UMTS 1900 / LTE 1900 / TD-LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10587,374,130,'National','Trinidad and Tobago','TT',216,'Digicel','Digicel (Trinidad & Tobago) Limited','Operational','GSM 850 / GSM 1900 / UMTS 1900',''),
	 (10588,374,140,'National','Trinidad and Tobago','TT',216,'','LaqTel Ltd.','Not operational','CDMA','Shut down 2008'),
	 (10589,605,1,'National','Tunisia','TN',217,'Orange','Orange Tunisie','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10590,605,2,'National','Tunisia','TN',217,'Tunicell','Tunisie Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10591,605,3,'National','Tunisia','TN',217,'OOREDOO TN','ooredoo Tunisiana','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800','former Orascom Telecom Tunisie'),
	 (10592,286,1,'National','Turkey','TR',218,'Turkcell','Turkcell Iletisim Hizmetleri A.S.','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (10593,286,2,'National','Turkey','TR',218,'Vodafone','Vodafone Turkey','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 900 / LTE 1800 / LTE 2600','Formerly known as Telsim'),
	 (10594,286,3,'National','Turkey','TR',218,'Türk Telekom','Türk Telekom','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Former Aria, merged with Aycell to form Avea'),
	 (10595,286,4,'National','Turkey','TR',218,'Aycell','Aycell','Not operational','GSM 1800','Merged into Aria to form Avea'),
	 (10596,438,1,'National','Turkmenistan','TM',219,'MTS','MTS Turkmenistan','Operational','GSM 900 / GSM 1800 / UMTS 2100','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10597,438,2,'National','Turkmenistan','TM',219,'TM-Cell','Altyn Asyr','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600',''),
	 (10598,438,3,'National','Turkmenistan','TM',219,'AGTS CDMA','AŞTU','Operational','CDMA 450',''),
	 (10599,338,50,'National','Turks and Caicos Islands','TC',220,'Digicel','Digicel (Turks & Caicos) Limited','Operational','GSM 900 / GSM 1800 / GSM 1900 / LTE 700',''),
	 (10600,376,350,'National','Turks and Caicos Islands','TC',220,'FLOW','Cable & Wireless West Indies Ltd (Turks & Caicos)','Operational','GSM 850 / LTE 700',''),
	 (10601,376,352,'National','Turks and Caicos Islands','TC',220,'FLOW','Cable & Wireless West Indies Ltd (Turks & Caicos)','Operational','UMTS 850','Former IslandCom'),
	 (10602,376,360,'National','Turks and Caicos Islands','TC',220,'FLOW','Cable & Wireless West Indies Ltd (Turks & Caicos)','Unknown','Unknown','Former IslandCom'),
	 (10603,553,1,'National','Tuvalu','TV',221,'TTC','Tuvalu Telecom','Operational','GSM 900 / LTE 850',''),
	 (10604,641,1,'National','Uganda','UG',222,'Airtel','Bharti Airtel','Operational','GSM 900 / UMTS 2100','Former Zain, Celtel'),
	 (10605,641,4,'National','Uganda','UG',222,'','Tangerine Uganda Limited','Operational','LTE',''),
	 (10606,641,6,'National','Uganda','UG',222,'Vodafone','Afrimax Uganda','Operational','TD-LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10607,641,10,'National','Uganda','UG',222,'MTN','MTN Uganda','Operational','GSM 900 / UMTS 900 / UMTS 2100 / LTE 2600','LTE band 7'),
	 (10608,641,11,'National','Uganda','UG',222,'Uganda Telecom','Uganda Telecom Ltd.','Operational','GSM 900 / UMTS 2100',''),
	 (10609,641,14,'National','Uganda','UG',222,'Africell','Africell Uganda','Operational','GSM 900 / GSM 1800 / UMTS / LTE 800','Former Orange, HiTS Telecom; LTE band 20'),
	 (10610,641,16,'National','Uganda','UG',222,'','SimbaNET Uganda Limited','Unknown','Unknown',''),
	 (10611,641,18,'National','Uganda','UG',222,'Smart','Suretelecom Uganda Ltd.','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10612,641,22,'National','Uganda','UG',222,'Airtel','Bharti Airtel','Operational','GSM 900 / GSM 1800 / UMTS','Former Warid Telecom'),
	 (10613,641,26,'National','Uganda','UG',222,'Lycamobile','Lycamobile Network Services Uganda Limited','Operational','MVNO',''),
	 (10614,641,30,'National','Uganda','UG',222,'','Anupam Global Soft Uganda Limited','Not operational','Unknown','MNC withdrawn'),
	 (10615,641,33,'National','Uganda','UG',222,'Smile','Smile Communications Uganda Limited','Operational','LTE 800','LTE band 20'),
	 (10616,641,40,'National','Uganda','UG',222,'','Civil Aviation Authority (CAA)','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10617,641,44,'National','Uganda','UG',222,'K2','K2 Telecom Ltd','Operational','MVNO',''),
	 (10618,641,66,'National','Uganda','UG',222,'i-Tel','i-Tel Ltd','Not operational','Unknown','MNC withdrawn'),
	 (10619,255,1,'National','Ukraine','UA',223,'Vodafone','PRJSC VF Ukraine','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','Former UMC, MTS; CDMA 450 shut down June 2018'),
	 (10620,255,2,'National','Ukraine','UA',223,'Beeline','Kyivstar GSM JSC','Not operational','GSM 900 / GSM 1800','Former WellCOM, URS; taken over by Kyivstar'),
	 (10621,255,3,'National','Ukraine','UA',223,'Kyivstar','Kyivstar JSC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600',''),
	 (10622,255,4,'National','Ukraine','UA',223,'IT','Intertelecom LLC','Operational','CDMA 800',''),
	 (10623,255,5,'National','Ukraine','UA',223,'Golden Telecom','Kyivstar GSM JSC','Not operational','GSM 1800','MNC withdrawn'),
	 (10624,255,6,'National','Ukraine','UA',223,'lifecell','Turkcell','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','Former life:) / Astelit'),
	 (10625,255,7,'National','Ukraine','UA',223,'3Mob','Trymob LLC','Operational','UMTS 2100','Former Utel, GSM roaming with MTS'),
	 (10626,255,21,'National','Ukraine','UA',223,'PEOPLEnet','Telesystems of Ukraine','Operational','CDMA 800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10627,255,23,'National','Ukraine','UA',223,'CDMA Ukraine','Intertelecom','Not operational','CDMA 800','Taken over by Intertelecom'),
	 (10628,255,25,'National','Ukraine','UA',223,'NEWTONE','CST Invest','Operational','CDMA 800',''),
	 (10629,424,2,'National','United Arab Emirates','AE',224,'Etisalat','Emirates Telecom Corp','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600',''),
	 (10630,424,3,'National','United Arab Emirates','AE',224,'du','Emirates Integrated Telecommunications Company','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800',''),
	 (10631,234,0,'National','United Kingdom','GB',225,'BT','BT Group','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (10632,234,1,'National','United Kingdom','GB',225,'Vectone Mobile','Mundio Mobile Limited','Operational','MVNO','Previously Mapesbury Communications Ltd.; uses EE network'),
	 (10633,234,2,'National','United Kingdom','GB',225,'O2 (UK)','Telefónica Europe','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / TD-LTE 2300',''),
	 (10634,234,3,'National','United Kingdom','GB',225,'Airtel-Vodafone','Jersey Airtel Ltd','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Guernsey, Jersey'),
	 (10635,234,4,'National','United Kingdom','GB',225,'FMS Solutions Ltd','FMS Solutions Ltd','Reserved','GSM 1800',''),
	 (10636,234,5,'National','United Kingdom','GB',225,'','COLT Mobile Telecommunications Limited','Not operational','','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10637,234,6,'National','United Kingdom','GB',225,'','Internet Computer Bureau Limited','Not operational','','MNC withdrawn'),
	 (10638,234,7,'National','United Kingdom','GB',225,'Vodafone UK','Vodafone','Not operational','GSM 1800','Former Cable & Wireless Worldwide; MNC withdrawn'),
	 (10639,234,8,'National','United Kingdom','GB',225,'','BT OnePhone (UK) Ltd','Unknown','',''),
	 (10640,234,9,'National','United Kingdom','GB',225,'','Tismi BV','Unknown','',''),
	 (10641,234,10,'National','United Kingdom','GB',225,'O2 (UK)','Telefónica Europe','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / TD-LTE 2300',''),
	 (10642,234,11,'National','United Kingdom','GB',225,'O2 (UK)','Telefónica Europe','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / TD-LTE 2300',''),
	 (10643,234,12,'National','United Kingdom','GB',225,'Railtrack','Network Rail Infrastructure Ltd','Operational','GSM-R',''),
	 (10644,234,13,'National','United Kingdom','GB',225,'Railtrack','Network Rail Infrastructure Ltd','Operational','GSM-R',''),
	 (10645,234,14,'National','United Kingdom','GB',225,'Hay Systems Ltd','Hay Systems Ltd','Operational','GSM 1800',''),
	 (10646,234,15,'National','United Kingdom','GB',225,'Vodafone UK','Vodafone','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600 / TD-LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10647,234,16,'National','United Kingdom','GB',225,'Talk Talk','TalkTalk Communications Limited','Operational','MVNO','Formerly Opal Tel Ltd; uses Vodafone network'),
	 (10648,234,17,'National','United Kingdom','GB',225,'','FleXtel Limited','Unknown','',''),
	 (10649,234,18,'National','United Kingdom','GB',225,'Cloud9','Cloud9','Operational','MVNO','Isle of Man network shut down'),
	 (10650,234,19,'National','United Kingdom','GB',225,'Private Mobile Networks PMN','Teleware plc','Operational','GSM 1800','Private GSM; roaming with Vodafone'),
	 (10651,234,20,'National','United Kingdom','GB',225,'3','Hutchison 3G UK Ltd','Operational','UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100','National roaming with Orange (UK)''s 2G network'),
	 (10652,234,21,'National','United Kingdom','GB',225,'','LogicStar Ltd','Not operational','Unknown','MNC withdrawn'),
	 (10653,234,22,'National','United Kingdom','GB',225,'','Telesign Mobile Limited','Unknown','Unknown','Former Routo Telecommunications Limited'),
	 (10654,234,23,'National','United Kingdom','GB',225,'','Icron Network Limited','Unknown','Unknown',''),
	 (10655,234,24,'National','United Kingdom','GB',225,'Greenfone','Stour Marine Limited','Operational','MVNO','Uses Stour Marine network'),
	 (10656,234,25,'National','United Kingdom','GB',225,'Truphone','Truphone','Operational','MVNO','Uses Vodafone network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10657,234,26,'National','United Kingdom','GB',225,'Lycamobile','Lycamobile UK Limited','Operational','MVNO','Uses O2 Network'),
	 (10658,234,27,'National','United Kingdom','GB',225,'','Teleena UK Limited','Operational','MVNE',''),
	 (10659,234,28,'National','United Kingdom','GB',225,'','Marathon Telecom Limited','Operational','MVNO','Holds unused spectrum in Jersey'),
	 (10660,234,29,'National','United Kingdom','GB',225,'aql','(aq) Limited','Unknown','Unknown',''),
	 (10661,234,30,'National','United Kingdom','GB',225,'T-Mobile UK','EE','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','Previously owned by Deutsche Telekom; used by MVNOs Asda Mobile & Virgin Mobile'),
	 (10662,234,31,'National','United Kingdom','GB',225,'T-Mobile UK','EE','Allocated','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (10663,234,32,'National','United Kingdom','GB',225,'T-Mobile UK','EE','Allocated','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600',''),
	 (10664,234,33,'National','United Kingdom','GB',225,'Orange','EE','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','Previously owned by Orange S.A.'),
	 (10665,234,34,'National','United Kingdom','GB',225,'Orange','EE','Operational','GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2100 / LTE 2600','Previously owned by Orange S.A.'),
	 (10666,234,35,'National','United Kingdom','GB',225,'','JSC Ingenium (UK) Limited','Not operational','Unknown','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10667,234,36,'National','United Kingdom','GB',225,'Sure Mobile','Sure Isle of Man Ltd.','Operational','GSM 900 / GSM 1800 / LTE','Isle of Man; former Cable & Wireless'),
	 (10668,234,37,'National','United Kingdom','GB',225,'','Synectiv Ltd','Unknown','Unknown',''),
	 (10669,234,38,'National','United Kingdom','GB',225,'Virgin Mobile','Virgin Media','Unknown','Unknown',''),
	 (10670,234,39,'National','United Kingdom','GB',225,'','Gamma Telecom Holdings Ltd.','Unknown','Unknown','Former SSE Energy Supply Limited'),
	 (10671,234,50,'National','United Kingdom','GB',225,'JT','JT Group Limited','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 800 / LTE 1800 / LTE 2600','Guernsey, Jersey; former Wave Telecom'),
	 (10672,234,51,'National','United Kingdom','GB',225,'Relish','UK Broadband Limited','Operational','TD-LTE 3500 / TD-LTE 3700',''),
	 (10673,234,52,'National','United Kingdom','GB',225,'','Shyam Telecom UK Ltd','Unknown','Unknown',''),
	 (10674,234,53,'National','United Kingdom','GB',225,'','Limitless Mobile Ltd','Operational','MVNO',''),
	 (10675,234,54,'National','United Kingdom','GB',225,'iD Mobile','The Carphone Warehouse Limited','Operational','MVNO','Uses Three UK'),
	 (10676,234,55,'National','United Kingdom','GB',225,'Sure Mobile','Sure (Guernsey) Limited','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800 / LTE 1800','Guernsey, Jersey; former Cable & Wireless');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10677,234,56,'National','United Kingdom','GB',225,'','CESG','Unknown','Unknown',''),
	 (10678,234,57,'National','United Kingdom','GB',225,'Sky Mobile','Sky UK Limited','Operational','MVNO O2','Sky UK (formerly British Sky Broadcasting Limited, BSkyB and Sky)'),
	 (10679,234,58,'National','United Kingdom','GB',225,'Pronto GSM','Manx Telecom','Operational','GSM 900 / UMTS 2100 / LTE 800 / LTE 1800','Isle of Man'),
	 (10680,234,59,'National','United Kingdom','GB',225,'','Limitless Mobile Ltd','Operational','MVNO',''),
	 (10681,234,70,'National','United Kingdom','GB',225,'','AMSUK Ltd.','Unknown','Unknown',''),
	 (10682,234,71,'National','United Kingdom','GB',225,'','Home Office','Unknown','Unknown',''),
	 (10683,234,72,'National','United Kingdom','GB',225,'','Hanhaa Limited','Operational','MVNO','M2M applications'),
	 (10684,234,76,'National','United Kingdom','GB',225,'BT','BT Group','Operational','GSM 900 / GSM 1800',''),
	 (10685,234,78,'National','United Kingdom','GB',225,'Airwave','Airwave Solutions Ltd','Operational','TETRA',''),
	 (10686,234,86,'National','United Kingdom','GB',225,'','EE','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10687,235,0,'National','United Kingdom','GB',225,'Vectone Mobile','Mundio Mobile Limited','Unknown','',''),
	 (10688,235,1,'National','United Kingdom','GB',225,'T-Mobile UK','EE','Unknown','Unknown',''),
	 (10689,235,2,'National','United Kingdom','GB',225,'','EE','Unknown','Unknown',''),
	 (10690,235,3,'National','United Kingdom','GB',225,'Relish','UK Broadband Limited','Unknown','Unknown',''),
	 (10691,235,77,'National','United Kingdom','GB',225,'BT','BT Group','Unknown','',''),
	 (10692,235,88,'National','United Kingdom','GB',225,'','Telet Research (N.I.) Limited','Unknown','LTE',''),
	 (10693,235,91,'National','United Kingdom','GB',225,'Vodafone UK','Vodafone United Kingdom','Unknown','',''),
	 (10694,235,92,'National','United Kingdom','GB',225,'Vodafone UK','Vodafone United Kingdom','Not operational','','Former Cable & Wireless UK; MNC withdrawn'),
	 (10695,235,94,'National','United Kingdom','GB',225,'','Hutchison 3G UK Ltd','Unknown','',''),
	 (10696,235,95,'National','United Kingdom','GB',225,'','Network Rail Infrastructure Limited','Test Network','GSM-R','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10697,310,4,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','Unknown',''),
	 (10698,310,5,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','CDMA2000 850 / CDMA2000 1900',''),
	 (10699,310,6,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','Unknown',''),
	 (10700,310,10,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','Unknown','Former MCI Inc.'),
	 (10701,310,12,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','LTE 700 / LTE 1700 / LTE 1900',''),
	 (10702,310,13,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former MobileTel, Alltel'),
	 (10703,310,14,'National','United States of America','US',226,'','','Unknown','Unknown','For testing'),
	 (10704,310,15,'National','United States of America','US',226,'Southern LINC','Southern Communications','Unknown','iDEN',''),
	 (10705,310,16,'National','United States of America','US',226,'AT&T','AT&T Mobility','Not operational','CDMA2000 1900 / CDMA2000 1700','Former Cricket Wireless; shut down in September 2015'),
	 (10706,310,17,'National','United States of America','US',226,'ProxTel','North Sight Communications Inc.','Not operational','iDEN','Puerto Rico; MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10707,310,20,'National','United States of America','US',226,'Union Wireless','Union Telephone Company','Operational','GSM 850 / GSM 1900 / UMTS',''),
	 (10708,310,30,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850','Former Centennial Wireless'),
	 (10709,310,32,'National','United States of America','US',226,'IT&E Wireless','IT&E Overseas, Inc','Operational','CDMA 1900 / GSM 1900 / LTE 700','Guam'),
	 (10710,310,33,'National','United States of America','US',226,'','Guam Telephone Authority','Unknown','Unknown',''),
	 (10711,310,34,'National','United States of America','US',226,'Airpeak','Airpeak','Operational','iDEN','Former Nevada Wireless'),
	 (10712,310,35,'National','United States of America','US',226,'ETEX Wireless','ETEX Communications, LP','Unknown','Unknown',''),
	 (10713,310,40,'National','United States of America','US',226,'MTA','Matanuska Telephone Association, Inc.','Not operational','CDMA','Formerly Concho Cellular Telephone Co.; then Alaska, shut down 2017; MNC withdrawn'),
	 (10714,310,50,'National','United States of America','US',226,'GCI','Alaska Communications','Operational','CDMA','Former ACS Wireless Inc.'),
	 (10715,310,53,'National','United States of America','US',226,'Virgin Mobile','Sprint','Operational','MVNO',''),
	 (10716,310,54,'National','United States of America','US',226,'','Alltel US','Operational','Unknown','Uses Sprint''s network');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10717,310,60,'National','United States of America','US',226,'','Consolidated Telcom','Unknown','1900','North Dakota'),
	 (10718,310,66,'National','United States of America','US',226,'U.S. Cellular','U.S. Cellular','Operational','GSM / CDMA',''),
	 (10719,310,70,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850','Former Highland Cellular, Cingular'),
	 (10720,310,80,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 1900','Former Corr Wireless Communications LLC'),
	 (10721,310,90,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 1900','Former Edge Wireless, Cingular, Cricket Wireless'),
	 (10722,310,100,'National','United States of America','US',226,'Plateau Wireless','New Mexico RSA 4 East LP','Operational','GSM 850 / UMTS 850 / UMTS 1700','Acquired by AT&T'),
	 (10723,310,110,'National','United States of America','US',226,'IT&E Wireless','PTI Pacifica Inc.','Operational','CDMA / GSM 850 / LTE 700','Northern Mariana Islands'),
	 (10724,310,120,'National','United States of America','US',226,'Sprint','Sprint Corporation','Operational','CDMA2000 1900 / LTE 850 / LTE 1900',''),
	 (10725,310,130,'National','United States of America','US',226,'Carolina West Wireless','Carolina West Wireless','Operational','CDMA2000 1900','North Carolina'),
	 (10726,310,140,'National','United States of America','US',226,'GTA Wireless','Teleguam Holdings, LLC','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 1700','Previously called Guam Telephone Authority mPulse');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10727,310,150,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850 / UMTS 850 / UMTS 1900','Originally BellSouth Mobility DCS, then Cingular Wireless, then Aio Wireless, then rebranded as the new GSM Cricket Wireless'),
	 (10728,310,160,'National','United States of America','US',226,'T-Mobile','T-Mobile USA','Operational','GSM 1900',''),
	 (10729,310,170,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 1900','Formerly Pacific Bell Wireless, then Cingular Wireless CA/NV known as \"Cingular Orange\"'),
	 (10730,310,180,'National','United States of America','US',226,'West Central','West Central Wireless','Operational','GSM 850 / UMTS 850 / UMTS 1900',''),
	 (10731,310,190,'National','United States of America','US',226,'GCI','Alaska Wireless Communications, LLC','Operational','GSM 850','Dutch Harbor, Alaska'),
	 (10732,310,200,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900',''),
	 (10733,310,210,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Iowa'),
	 (10734,310,220,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Kansas / Oklahoma'),
	 (10735,310,230,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Utah'),
	 (10736,310,240,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','New Mexico / Texas / Arizona');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10737,310,250,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Hawaii'),
	 (10738,310,260,'National','United States of America','US',226,'T-Mobile','T-Mobile USA','Operational','GSM 1900 / UMTS 1900 / UMTS 1700 / LTE 850 / LTE 700 / LTE 1900 / LTE 1700','Former Cook Inlet West Wireless, Voicestream; now universal USA code. Also used for Ting.'),
	 (10739,310,270,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Formerly Powertel'),
	 (10740,310,280,'National','United States of America','US',226,'AT&T','AT&T Mobility','Not operational','GSM 1900','Former Centennial Puerto Rico'),
	 (10741,310,290,'National','United States of America','US',226,'nep','NEP Cellcorp Inc.','Not operational','GSM 1900','Shut down 22 September 2015'),
	 (10742,310,300,'National','United States of America','US',226,'Big Sky Mobile','iSmart Mobile, LLC','Not operational','GSM 1900','Montana; former Get Mobile Inc., SmartCall, LLC; acquired by T-Mobile in 2017'),
	 (10743,310,310,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Formerly Aerial Communications'),
	 (10744,310,311,'National','United States of America','US',226,'','Farmers Wireless','Not operational','GSM 1900','NE Alabama; acquired by AT&T in 2008'),
	 (10745,310,320,'National','United States of America','US',226,'Cellular One','Smith Bagley, Inc.','Operational','GSM 850 / GSM 1900 / UMTS','Arizona / New Mexico'),
	 (10746,310,330,'National','United States of America','US',226,'','Wireless Partners, LLC','Unknown','LTE','Former AN Subsidiary LLC, AWCC, - acquired by AT&T, CDMA shut down February 2015;');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10747,310,340,'National','United States of America','US',226,'Limitless Mobile','Limitless Mobile, LLC','Unknown','GSM 1900','Kansas; Former High Plains Midwest LLC dba Westlink Communications, acquired by United Wireless in 2013; in bankruptcy since November 2016'),
	 (10748,310,350,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','CDMA','Former Mohave Cellular L.P.'),
	 (10749,310,360,'National','United States of America','US',226,'Pioneer Cellular','Cellular Network Partnership','Operational','CDMA','Oklahoma'),
	 (10750,310,370,'National','United States of America','US',226,'Docomo','NTT Docomo Pacific','Operational','GSM 1900 / UMTS 850 / LTE 700','Guam, Northern Mariana Islands; former Guamcell'),
	 (10751,310,380,'National','United States of America','US',226,'AT&T','AT&T Mobility','Not operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900','Former AT&T Wireless Services, then Cingular Wireless (known as \"Cingular Blue\")'),
	 (10752,310,390,'National','United States of America','US',226,'Cellular One of East Texas','TX-11 Acquisition, LLC','Operational','GSM 850 / LTE 700 / CDMA','Former Yorkville Telephone Cooperative'),
	 (10753,310,400,'National','United States of America','US',226,'iConnect','Wave Runner LLC','Operational','GSM 1900 / UMTS 1900 / LTE 700','Guam'),
	 (10754,310,410,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900','Formerly Cingular Wireless, also used in Puerto Rico and U.S. Virgin Islands'),
	 (10755,310,420,'National','United States of America','US',226,'Cincinnati Bell','Cincinnati Bell Wireless','Not operational','GSM 1900 / UMTS 1700','Shut down 28 February 2015; MNC withdrawn'),
	 (10756,310,430,'National','United States of America','US',226,'GCI','GCI Communications Corp.','Operational','GSM 1900 / UMTS 1900','Former Alaska Digitel');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10757,310,440,'National','United States of America','US',226,'','Numerex','Operational','MVNO','Former Dobson / Cellular One; M2M only'),
	 (10758,310,450,'National','United States of America','US',226,'Viaero','Viaero Wireless','Operational','GSM 850 / GSM 1900 / UMTS 850 / UMTS 1900','Formerly North East Cellular Inc., CellONE; Colorado / Kansas / Nebraska'),
	 (10759,310,460,'National','United States of America','US',226,'NewCore','NewCore Wireless LLC','Operational','GSM 1900','Former Simmetry / TMP Corporation (shut down 30 June 2012)'),
	 (10760,310,470,'National','United States of America','US',226,'Shentel','Shenandoah Telecommunications Company','Operational','CDMA2000 1900','Former nTelos; note that 310-470 may also be in use by Docomo Pacific'),
	 (10761,310,480,'National','United States of America','US',226,'iConnect','Wave Runner LLC','Operational','iDEN','Guam; also known as Choice Phone LLC'),
	 (10762,310,490,'National','United States of America','US',226,'T-Mobile','T-Mobile','Operational','GSM 850 / GSM 1900','Former Triton PCS, SunCom'),
	 (10763,310,500,'National','United States of America','US',226,'Alltel','Public Service Cellular Inc.','Operational','CDMA2000 850 / CDMA2000 1900','Georgia'),
	 (10764,310,510,'National','United States of America','US',226,'Cellcom','Nsighttel Wireless LLC','Unknown','Unknown','Formerly Airtel Wireless LLC (iDEN, Montana)'),
	 (10765,310,520,'National','United States of America','US',226,'TNS','Transaction Network Services','Unknown','Unknown','Formerly Verisign'),
	 (10766,310,530,'National','United States of America','US',226,'iWireless','Iowa Wireless Services LLC','Unknown','Unknown','Formerly West Virginia Wireless (bought by Verizon in 2007)');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10767,310,540,'National','United States of America','US',226,'Phoenix','Oklahoma Western Telephone Company','Operational','GSM 850 / GSM 1900','Oklahoma'),
	 (10768,310,550,'National','United States of America','US',226,'','Syniverse Technologies','Unknown','Unknown','Former Wireless Solutions International'),
	 (10769,310,560,'National','United States of America','US',226,'AT&T','AT&T Mobility','Not operational','GSM 850','Former Dobson Cellular, Cingular Wireless; MNC withdrawn'),
	 (10770,310,570,'National','United States of America','US',226,'Cellular One','TX-10, LLC and Central Louisiana Cellular, LLC (MTPCS)','Operational','GSM 850 / LTE 700','Montana network (former Chinook Wireless) shut down in 2014'),
	 (10771,310,580,'National','United States of America','US',226,'','Inland Cellular Telephone Company','Operational','CDMA2000','Former PCS One'),
	 (10772,310,590,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','GSM 850 / GSM 1900','Former Western Wireless Corporation, Alltel, then Verizon'),
	 (10773,310,600,'National','United States of America','US',226,'Cellcom','New-Cell Inc.','Operational','CDMA2000 850 / CDMA2000 1900','Wisconsin'),
	 (10774,310,610,'National','United States of America','US',226,'Epic PCS','Elkhart Telephone Co.','Not operational','GSM 1900','Shut down 30 April 2015, sold to PTCI and United Wireless; MNC withdrawn'),
	 (10775,310,620,'National','United States of America','US',226,'Cellcom','Nsighttel Wireless LLC','Unknown','Unknown','Formerly Coleman County Telecom'),
	 (10776,310,630,'National','United States of America','US',226,'miSpot','Agri-Valley Communications','Not operational','LTE 700','Shut down 30 November 2014');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10777,310,640,'National','United States of America','US',226,'','Numerex','Operational','MVNO','M2M only; formerly Einstein PCS, AirFire / Airadigm, shut down 2 September 2014'),
	 (10778,310,650,'National','United States of America','US',226,'Jasper','Jasper Technologies','Operational','MVNO','M2M only'),
	 (10779,310,660,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Formerly DigiPhone PCS / DigiPH'),
	 (10780,310,670,'National','United States of America','US',226,'AT&T','AT&T Mobility','Unknown','Unknown','Former Northstar'),
	 (10781,310,680,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850 / GSM 1900','Formerly Cellular One DCS, NPI Wireless, Cingular'),
	 (10782,310,690,'National','United States of America','US',226,'Limitless Mobile','Limitless Mobile, LLC','Unknown','GSM 1900 / LTE 1900','Former Conestoga Wireless, Keystone Wireless d/b/a Immix Wireless; in bankruptcy since November 2016'),
	 (10783,310,700,'National','United States of America','US',226,'Bigfoot Cellular','Cross Valiant Cellular Partnership','Unknown','GSM',''),
	 (10784,310,710,'National','United States of America','US',226,'ASTAC','Arctic Slope Telephone Association Cooperative','Operational','UMTS 850','Alaska; GSM shut down January 2017'),
	 (10785,310,720,'National','United States of America','US',226,'','Syniverse Technologies','Unknown','Unknown','Former Wireless Solutions International'),
	 (10786,310,730,'National','United States of America','US',226,'U.S. Cellular','U.S. Cellular','Unknown','Unknown','Formerly Sea Mobile');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10787,310,740,'National','United States of America','US',226,'Viaero','Viaero Wireless','Operational','LTE 700 / LTE 1700 / LTE 1900','Former Telemetrix Technologies, Convey Communications Inc., Green Eagle Communications, Inc.'),
	 (10788,310,750,'National','United States of America','US',226,'Appalachian Wireless','East Kentucky Network, LLC','Operational','CDMA2000 850 / CDMA2000 1900',''),
	 (10789,310,760,'National','United States of America','US',226,'','Lynch 3G Communications Corporation','Not operational','Unknown',''),
	 (10790,310,770,'National','United States of America','US',226,'iWireless','Iowa Wireless Services','Operational','GSM 1900 / UMTS 1700 / LTE 1700 / LTE 1900','Iowa'),
	 (10791,310,780,'National','United States of America','US',226,'Dispatch Direct','D. D. Inc.','Operational','iDEN','Former Airlink PCS, Connect Net Inc.'),
	 (10792,310,790,'National','United States of America','US',226,'BLAZE','PinPoint Communications Inc.','Operational','GSM 1900 / UMTS / LTE','Nebraska'),
	 (10793,310,800,'National','United States of America','US',226,'T-Mobile','T-Mobile','Not operational','GSM 1900','Formerly SOL Communications'),
	 (10794,310,810,'National','United States of America','US',226,'','LCFR LLC','Not operational','1900','Owned by New Dimension Wireless; formerly Brazos Cellular Communications Ltd.; MNC withdrawn'),
	 (10795,310,820,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former South Canaan Cellular'),
	 (10796,310,830,'National','United States of America','US',226,'Sprint','Sprint Corporation','Not operational','WiMAX','Former Caprock Cellular (GSM, sold to AT&T in 2010), Clearwire');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10797,310,840,'National','United States of America','US',226,'telna Mobile','Telecom North America Mobile, Inc.','Operational','MVNO','Formerly Edge Mobile LLC'),
	 (10798,310,850,'National','United States of America','US',226,'Aeris','Aeris Communications, Inc.','Operational','MVNO','M2M only; is a Full MVNO despite marketing claims to the contrary'),
	 (10799,310,860,'National','United States of America','US',226,'Five Star Wireless','TX RSA 15B2, LP','Operational','CDMA','Owned by West Central Wireless'),
	 (10800,310,870,'National','United States of America','US',226,'PACE','Kaplan Telephone Company','Not operational','GSM 850','Louisiana; spectrum sold to AT&T in 2014; MNC withdrawn'),
	 (10801,310,880,'National','United States of America','US',226,'DTC Wireless','Advantage Cellular Systems, Inc.','Operational','LTE','Tennessee; owned by DeKalb Telephone Cooperative; fixed wireless only, GSM 850 discontinued January 2017'),
	 (10802,310,890,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','GSM 850 / GSM 1900','Former Unicel / Rural Cellular Corporation'),
	 (10803,310,900,'National','United States of America','US',226,'Mid-Rivers Wireless','Cable & Communications Corporation','Operational','CDMA2000 850 / CDMA2000 1900','Montana'),
	 (10804,310,910,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','GSM 850','Former First Cellular of Southern Illinois, Alltel'),
	 (10805,310,920,'National','United States of America','US',226,'','James Valley Wireless, LLC','Operational','CDMA','South Dakota; includes NVC'),
	 (10806,310,930,'National','United States of America','US',226,'','Copper Valley Wireless','Operational','CDMA','Alaska');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10807,310,940,'National','United States of America','US',226,'','Tyntec Inc.','Unknown','MVNO','Formerly Poka Lambro Telecommunications Ltd., Iris Wireless LLC'),
	 (10808,310,950,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850','Former Texas RSA 1 d/b/a XIT Cellular'),
	 (10809,310,960,'National','United States of America','US',226,'STRATA','UBET Wireless','Operational','CDMA','Utah'),
	 (10810,310,970,'National','United States of America','US',226,'','Globalstar','Operational','Satellite',''),
	 (10811,310,980,'National','United States of America','US',226,'Peoples Telephone','Texas RSA 7B3','Not operational','CDMA / LTE 700','Texas; spectrum sold to AT&T; MNC withdrawn'),
	 (10812,310,990,'National','United States of America','US',226,'Evolve Broadband','Worldcall Interconnect Inc.','Operational','LTE 700','LTE band 17'),
	 (10813,311,0,'National','United States of America','US',226,'West Central Wireless','Mid-Tex Cellular Ltd.','Operational','CDMA2000 850 / CDMA2000 1900','Texas'),
	 (10814,311,10,'National','United States of America','US',226,'Chariton Valley','Chariton Valley Communications','Operational','CDMA2000 850 / CDMA2000 1900','Missouri'),
	 (10815,311,12,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','CDMA2000 850 / CDMA2000 1900',''),
	 (10816,311,20,'National','United States of America','US',226,'Chariton Valley','Missouri RSA 5 Partnership','Operational','GSM 850','Missouri');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10817,311,30,'National','United States of America','US',226,'Indigo Wireless','Americell PA 3 Partnership','Operational','GSM 850 / GSM 1900 / UMTS 850','Pennsylvania'),
	 (10818,311,40,'National','United States of America','US',226,'Choice Wireless','Commnet Wireless','Operational','GSM 850 / GSM 1900 / CDMA 2000 / UMTS',''),
	 (10819,311,50,'National','United States of America','US',226,'','Thumb Cellular LP','Operational','CDMA2000 850','Michigan'),
	 (10820,311,60,'National','United States of America','US',226,'','Space Data Corporation','Operational','Unknown','Former Farmers Cellular Telephone Inc.'),
	 (10821,311,70,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 850','Former Easterbrooke Cellular Corporation, Wisconsin RSA #7 Limited Partnership'),
	 (10822,311,80,'National','United States of America','US',226,'Pine Cellular','Pine Telephone Company','Operational','GSM 850 / LTE','Oklahoma'),
	 (10823,311,90,'National','United States of America','US',226,'AT&T','AT&T Mobility','Operational','GSM 1900','Former Siouxland PCS, Long Lines Wireless, acquired by AT&T Dec. 2013'),
	 (10824,311,100,'National','United States of America','US',226,'','Nex-Tech Wireless','Operational','CDMA2000','Kansas; former High Plains Wireless L.P.'),
	 (10825,311,110,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former High Plains Wireless L.P., Alltel'),
	 (10826,311,120,'National','United States of America','US',226,'iConnect','Wave Runner LLC','Operational','Unknown','Guam; also known as Choice Phone LLC');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10827,311,130,'National','United States of America','US',226,'','Lightsquared L.P.','Not operational','LTE','Former Cell One Amarillo (Amarillo License L.P.); MNC withdrawn'),
	 (10828,311,140,'National','United States of America','US',226,'Bravado Wireless','Cross Telephone Company','Operational','CDMA','Oklahoma; former MBO Wireless, Sprocket Wireless'),
	 (10829,311,150,'National','United States of America','US',226,'','Wilkes Cellular','Operational','GSM 850','Georgia'),
	 (10830,311,160,'National','United States of America','US',226,'','Lightsquared L.P.','Not operational','LTE','Former Endless Mountains Wireless (acquired by Dobson Cellular in 2005) MNC withdrawn'),
	 (10831,311,170,'National','United States of America','US',226,'','Broadpoint Inc.','Operational','GSM 850','Gulf of Mexico; former PetroCom'),
	 (10832,311,180,'National','United States of America','US',226,'AT&T','AT&T Mobility','Not operational','GSM 850 / UMTS 850 / UMTS 1900','Former Pacific Telesis, Cingular Wireless'),
	 (10833,311,190,'National','United States of America','US',226,'AT&T','AT&T Mobility','Unknown','Unknown','Former Cellular Properties Inc.'),
	 (10834,311,200,'National','United States of America','US',226,'','ARINC','Not operational','Unknown','MNC withdrawn'),
	 (10835,311,210,'National','United States of America','US',226,'','Telnyx LLC','Operational','MVNO','Former Farmers Cellular Telephone, Emery Telcom Wireless'),
	 (10836,311,220,'National','United States of America','US',226,'U.S. Cellular','U.S. Cellular','Operational','CDMA','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10837,311,230,'National','United States of America','US',226,'C Spire Wireless','Cellular South Inc.','Operational','CDMA 850 / CDMA 1900 / LTE 700 / LTE 850 / LTE 1700 / LTE 1900 / TD-LTE 2500',''),
	 (10838,311,240,'National','United States of America','US',226,'','Cordova Wireless','Operational','GSM / UMTS 850 / WiMAX','Alaska'),
	 (10839,311,250,'National','United States of America','US',226,'iConnect','Wave Runner LLC','Operational','Unknown','Guam'),
	 (10840,311,260,'National','United States of America','US',226,'Sprint','Sprint Corporation','Not operational','WiMAX','Former CellularOne of San Luis Obispo (sold to AT&T in 2010, Clearwire'),
	 (10841,311,270,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10842,311,271,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10843,311,272,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10844,311,273,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10845,311,274,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10846,311,275,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10847,311,276,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10848,311,277,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10849,311,278,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10850,311,279,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Alltel'),
	 (10851,311,280,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10852,311,281,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10853,311,282,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10854,311,283,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10855,311,284,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10856,311,285,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10857,311,286,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10858,311,287,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10859,311,288,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10860,311,289,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (10861,311,290,'National','United States of America','US',226,'BLAZE','PinPoint Communications Inc.','Operational','GSM 1900 / UMTS / LTE','Nebraska'),
	 (10862,311,300,'National','United States of America','US',226,'','Nexus Communications, Inc.','Not operational','Unknown','Former Rutal Cellular Corporation; MNC withdrawn'),
	 (10863,311,310,'National','United States of America','US',226,'NMobile','Leaco Rural Telephone Company Inc.','Operational','CDMA2000','New Mexico'),
	 (10864,311,320,'National','United States of America','US',226,'Choice Wireless','Commnet Wireless','Operational','GSM 850 / GSM 1900 / CDMA 2000 / UMTS',''),
	 (10865,311,330,'National','United States of America','US',226,'Bug Tussel Wireless','Bug Tussel Wireless LLC','Operational','GSM 1900 / LTE 1700 / WiMAX 3700','Wisconsin'),
	 (10866,311,340,'National','United States of America','US',226,'','Illinois Valley Cellular','Operational','CDMA2000 / LTE 850','Illinois');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10867,311,350,'National','United States of America','US',226,'Nemont','Sagebrush Cellular, Inc.','Operational','CDMA2000','Former Torrestar Networks Inc.; Montana'),
	 (10868,311,360,'National','United States of America','US',226,'','Stelera Wireless','Not operational','UMTS 1700','shut down 30 April 2013'),
	 (10869,311,370,'National','United States of America','US',226,'GCI Wireless','General Communication Inc.','Operational','LTE 1700','Former Alaska Communications'),
	 (10870,311,380,'National','United States of America','US',226,'','New Dimension Wireless Ltd.','Operational','MVNO',''),
	 (10871,311,390,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former Midwest Wireless Holdings LLC, Alltel'),
	 (10872,311,400,'National','United States of America','US',226,'','','Unknown','Unknown','Former Salmon PCS LLC, New Cingular Wireless PCS LLC; for testing'),
	 (10873,311,410,'National','United States of America','US',226,'Chat Mobility','Iowa RSA No. 2 LP','Operational','CDMA','Iowa'),
	 (10874,311,420,'National','United States of America','US',226,'NorthwestCell','Northwest Missouri Cellular LP','Operational','CDMA','Missouri'),
	 (10875,311,430,'National','United States of America','US',226,'Chat Mobility','RSA 1 LP','Unknown','CDMA','Former Cellular 29 Plus; acquired by Chat Mobility in 2009; Iowa'),
	 (10876,311,440,'National','United States of America','US',226,'','Bluegrass Cellular LLC','Operational','CDMA','Kentucky');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10877,311,450,'National','United States of America','US',226,'PTCI','Panhandle Telecommunication Systems Inc.','Operational','GSM 1900 / LTE 700','Also known as Panhandle Telephone Cooperative, Inc.; Oklahoma'),
	 (10878,311,460,'National','United States of America','US',226,'','Electric Imp Inc.','Unknown','Unknown','Former Fisher Wireless Services Inc.'),
	 (10879,311,470,'National','United States of America','US',226,'Viya','Vitelcom Cellular Inc.','Operational','GSM 850 / GSM 1900 / TD-LTE 2500','Former Innovative Wireless; US Virgin Islands'),
	 (10880,311,480,'National','United States of America','US',226,'Verizon','Verizon Wireless','Operational','LTE 700','C Block'),
	 (10881,311,481,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10882,311,482,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10883,311,483,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10884,311,484,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10885,311,485,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10886,311,486,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10887,311,487,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10888,311,488,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10889,311,489,'National','United States of America','US',226,'Verizon','Verizon Wireless','Not operational','LTE 700','C Block for future use'),
	 (10890,311,490,'National','United States of America','US',226,'Sprint','Sprint Corporation','Operational','LTE 850 / LTE 1900 / TD-LTE 2500','Former Wirefree Partners LLC, acquired by Sprint in 2010; LTE bands 25, 26, 41'),
	 (10891,311,500,'National','United States of America','US',226,'','Mosaic Telecom','Not operational','UMTS / LTE 700 / LTE 1700','Former CTC Telecom Inc.; discontinued cellular service in 2016; MNC withdrawn'),
	 (10892,311,510,'National','United States of America','US',226,'','Ligado Networks','Not operational','LTE','Former Benton-Lian Wireless, Lightsquared L.P.'),
	 (10893,311,520,'National','United States of America','US',226,'','Lightsquared L.P.','Not operational','LTE','Former Crossroads Wireless Inc.; MNC withdrawn'),
	 (10894,311,530,'National','United States of America','US',226,'NewCore','NewCore Wireless LLC','Operational','LTE 1900','Former Wireless Communications Venture'),
	 (10895,311,540,'National','United States of America','US',226,'','Proximiti Mobility Inc.','Not operational','GSM 850','Former Keystone Wireless Inc.; MNC withdrawn'),
	 (10896,311,550,'National','United States of America','US',226,'Choice Wireless','Commnet Midwest LLC','Operational','GSM 850 / GSM 1900 / CDMA 2000 / UMTS','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10897,311,560,'National','United States of America','US',226,'OTZ Cellular','OTZ Communications, Inc.','Operational','GSM 850','Alaska'),
	 (10898,311,570,'National','United States of America','US',226,'BendBroadband','Bend Cable Communications LLC','Not operational','UMTS 1700 / LTE 1700','shut down 25-July-2014; MNC withdrawn'),
	 (10899,311,580,'National','United States of America','US',226,'U.S. Cellular','U.S. Cellular','Operational','LTE 700 / LTE 850',''),
	 (10900,311,590,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown','Former California RSA No3 Ltd Partnership d/b/a Golden State Cellular, acquired by Verizon in 2014'),
	 (10901,311,600,'National','United States of America','US',226,'Limitless Mobile','Limitless Mobile, LLC','Unknown','CDMA','Former Cox Wireless, shut down in 2012; in bankruptcy since November 2016'),
	 (10902,311,610,'National','United States of America','US',226,'SRT Communications','North Dakota Network Co.','Not operational','CDMA','North Dakota; shut down in 2017'),
	 (10903,311,620,'National','United States of America','US',226,'','TerreStar Networks, Inc.','Not operational','Satellite',''),
	 (10904,311,630,'National','United States of America','US',226,'C Spire Wireless','Cellular South Inc.','Unknown','Unknown','Former Corr Wireless Communications'),
	 (10905,311,640,'National','United States of America','US',226,'Rock Wireless','Standing Rock Telecommunications','Operational','LTE 700','A Block; covering an American Indian reservation straddling remote parts of North and South Dakota'),
	 (10906,311,650,'National','United States of America','US',226,'United Wireless','United Wireless','Operational','CDMA / LTE 700 / WiMAX 3700','Kansas');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10907,311,660,'National','United States of America','US',226,'metroPCS','MetroPCS Wireless Inc.','Operational','MVNO','CDMA2000 1900 / CDMA2000 1700 shut down in 2015; LTE 1700 merged with T-Mobile US'),
	 (10908,311,670,'National','United States of America','US',226,'Pine Belt Wireless','Pine Belt Cellular Inc.','Operational','CDMA','Alabama'),
	 (10909,311,680,'National','United States of America','US',226,'','GreenFly LLC','Unknown','GSM 1900','Iowa'),
	 (10910,311,690,'National','United States of America','US',226,'','TeleBEEPER of New Mexico','Operational','paging','New Mexico; 850 MHz band never used'),
	 (10911,311,700,'National','United States of America','US',226,'','Midwest Network Solutions Hub LLC','Unknown','MVNO','Former TotalSolutions Telecom LLC, Aspenta International, Inc.'),
	 (10912,311,710,'National','United States of America','US',226,'','Northeast Wireless Networks LLC','Unknown','Unknown',''),
	 (10913,311,720,'National','United States of America','US',226,'','MainePCS LLC','Not operational','GSM 1900','Bankrupt in 2009'),
	 (10914,311,730,'National','United States of America','US',226,'','Proximiti Mobility Inc.','Unknown','GSM 850','Former Keystone Wireless Inc.'),
	 (10915,311,740,'National','United States of America','US',226,'','Telalaska Cellular','Operational','GSM 850','Alaska'),
	 (10916,311,750,'National','United States of America','US',226,'ClearTalk','Flat Wireless LLC','Unknown','Unknown','Former NetAmerica Alliance');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10917,311,760,'National','United States of America','US',226,'','Edigen Inc.','Not operational','Unknown','MNC withdrawn'),
	 (10918,311,770,'National','United States of America','US',226,'','Altiostar Networks, Inc.','Unknown','Unknown','Former Geneseo Communications Services Inc., Radio Mobile Access Inc.'),
	 (10919,311,780,'National','United States of America','US',226,'Pioneer Cellular','Cellular Network Partnership','Not operational','Unknown','MNC withdrawn'),
	 (10920,311,790,'National','United States of America','US',226,'','Coleman County Telephone Cooperative, Inc.','Unknown','Unknown','Former Cellular Network Partnership d/b/a Pioneer Cellular'),
	 (10921,311,800,'National','United States of America','US',226,'','Bluegrass Cellular LLC','Operational','LTE 700','Kentucky'),
	 (10922,311,810,'National','United States of America','US',226,'','Bluegrass Cellular LLC','Operational','LTE 700','Kentucky'),
	 (10923,311,820,'National','United States of America','US',226,'','Sonus Networks','Unknown','Unknown','Former Kineto Wireless Inc.'),
	 (10924,311,830,'National','United States of America','US',226,'','Thumb Cellular LP','Operational','LTE 700','Michigan'),
	 (10925,311,840,'National','United States of America','US',226,'Cellcom','Nsight Spectrum LLC','Operational','LTE 700','Wisconsin'),
	 (10926,311,850,'National','United States of America','US',226,'Cellcom','Nsight Spectrum LLC','Operational','LTE 700','Wisconsin');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10927,311,860,'National','United States of America','US',226,'STRATA','Uintah Basin Electronic Telecommunications','Operational','LTE 700','Utah'),
	 (10928,311,870,'National','United States of America','US',226,'Boost Mobile','Sprint Corporation','Operational','MVNO',''),
	 (10929,311,880,'National','United States of America','US',226,'Sprint','Sprint Corporation','Unknown','Unknown',''),
	 (10930,311,890,'National','United States of America','US',226,'','Globecomm Network Services Corporation','Unknown','Unknown',''),
	 (10931,311,900,'National','United States of America','US',226,'','GigSky','Operational','MVNO',''),
	 (10932,311,910,'National','United States of America','US',226,'MobileNation','SI Wireless LLC','Operational','CDMA / LTE','Tennessee'),
	 (10933,311,920,'National','United States of America','US',226,'Chariton Valley','Missouri RSA 5 Partnership','Unknown','Unknown','Missouri'),
	 (10934,311,930,'National','United States of America','US',226,'','Syringa Wireless','Not operational','LTE 700','Former Cablevision Systems Corporation; Idaho; fixed broadband; shut down Dec 2015'),
	 (10935,311,940,'National','United States of America','US',226,'Sprint','Sprint Corporation','Not operational','WiMAX','Former Clearwire'),
	 (10936,311,950,'National','United States of America','US',226,'ETC','Enhanced Telecommmunications Corp.','Operational','CDMA / LTE 700','Former Sunman Telecommunications Corp.; Indiana; fixed broadband');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10937,311,960,'National','United States of America','US',226,'Lycamobile','Lycamobile USA Inc.','Operational','MVNO','uses T-Mobile'),
	 (10938,311,970,'National','United States of America','US',226,'Big River Broadband','Big River Broadband, LLC','Operational','LTE 1700','Utilizing 20 MHz in A block'),
	 (10939,311,980,'National','United States of America','US',226,'','LigTel Communications','Unknown','Unknown',''),
	 (10940,311,990,'National','United States of America','US',226,'','VTel Wireless','Operational','LTE 700 / LTE 1700',''),
	 (10941,312,10,'National','United States of America','US',226,'Chariton Valley','Chariton Valley Communication Corporation, Inc','Unknown','Unknown','Missouri'),
	 (10942,312,20,'National','United States of America','US',226,'','Infrastructure Networks, LLC','Operational','LTE 700','Focused on oil & gas industries'),
	 (10943,312,30,'National','United States of America','US',226,'Bravado Wireless','Cross Wireless','Operational','LTE 700','Oklahoma; former MBO Wireless, Sprocket Wireless'),
	 (10944,312,40,'National','United States of America','US',226,'','Custer Telephone Co-op (CTCI)','Operational','LTE 700','Idaho'),
	 (10945,312,50,'National','United States of America','US',226,'','Fuego Wireless','Not operational','LTE 700','fixed broadband; New Mexico; shut down in 2016, spectrum sold to AT&T and Infrastructure Networks; MNC withdrawn'),
	 (10946,312,60,'National','United States of America','US',226,'','CoverageCo','Unknown','CDMA / GSM','Vermont');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10947,312,70,'National','United States of America','US',226,'','Adams Networks Inc','Operational','LTE 700','C block fixed broadband; Illinois'),
	 (10948,312,80,'National','United States of America','US',226,'SyncSouth','South Georgia Regional Information Technology Authority','Operational','UMTS-TDD 700','LTE 700 planned'),
	 (10949,312,90,'National','United States of America','US',226,'AT&T','AT&T Mobility','Unknown','Unknown','Former Allied Wireless'),
	 (10950,312,100,'National','United States of America','US',226,'','ClearSky Technologies, Inc.','Unknown','Unknown',''),
	 (10951,312,110,'National','United States of America','US',226,'','Texas Energy Network LLC','Not operational','LTE','MNC withdrawn'),
	 (10952,312,120,'National','United States of America','US',226,'Appalachian Wireless','East Kentucky Network, LLC','Operational','LTE 700',''),
	 (10953,312,130,'National','United States of America','US',226,'Appalachian Wireless','East Kentucky Network, LLC','Operational','LTE 700',''),
	 (10954,312,140,'National','United States of America','US',226,'Revol Wireless','Cleveland Unlimited, Inc.','Not operational','CDMA','Shut down 2014, acquired by Sprint; MNC withdrawn'),
	 (10955,312,150,'National','United States of America','US',226,'NorthwestCell','Northwest Missouri Cellular LP','Operational','LTE 700','Missouri'),
	 (10956,312,160,'National','United States of America','US',226,'Chat Mobility','RSA1 Limited Partnership','Operational','LTE 700','Iowa');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10957,312,170,'National','United States of America','US',226,'Chat Mobility','Iowa RSA No. 2 LP','Operational','LTE 700','Iowa'),
	 (10958,312,180,'National','United States of America','US',226,'','Limiteless Mobile LLC','Unknown','Unknown','Former Keystone Wireless LLC'),
	 (10959,312,190,'National','United States of America','US',226,'Sprint','Sprint Corporation','Unknown','Unknown',''),
	 (10960,312,200,'National','United States of America','US',226,'','Voyager Mobility LLC','Not operational','MVNO','Shut down 2015; MNC withdrawn'),
	 (10961,312,210,'National','United States of America','US',226,'','Aspenta International, Inc.','Operational','MVNO',''),
	 (10962,312,220,'National','United States of America','US',226,'Chariton Valley','Chariton Valley Communication Corporation, Inc.','Operational','LTE 700',''),
	 (10963,312,230,'National','United States of America','US',226,'SRT Communications','North Dakota Network Co.','Not operational','Unknown','North Dakota; shut down in 2017'),
	 (10964,312,240,'National','United States of America','US',226,'Sprint','Sprint Corporation','Unknown','Unknown','Former Clearwire'),
	 (10965,312,250,'National','United States of America','US',226,'Sprint','Sprint Corporation','Unknown','Unknown','Former Clearwire'),
	 (10966,312,260,'National','United States of America','US',226,'NewCore','Central LTE Holdings','Operational','LTE 1900','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10967,312,270,'National','United States of America','US',226,'Pioneer Cellular','Cellular Network Partnership','Operational','LTE 700','Oklahoma'),
	 (10968,312,280,'National','United States of America','US',226,'Pioneer Cellular','Cellular Network Partnership','Operational','LTE 700','Oklahoma'),
	 (10969,312,290,'National','United States of America','US',226,'STRATA','Uintah Basin Electronic Telecommunications','Unknown','Unknown',''),
	 (10970,312,300,'National','United States of America','US',226,'telna Mobile','Telecom North America Mobile, Inc.','Operational','MVNO',''),
	 (10971,312,310,'National','United States of America','US',226,'','Clear Stream Communications, LLC','Operational','LTE 700','North Carolina; owned by Carolina West Wireless, Wilkes Communications'),
	 (10972,312,320,'National','United States of America','US',226,'','S and R Communications LLC','Operational','LTE 700','Indiana'),
	 (10973,312,330,'National','United States of America','US',226,'Nemont','Nemont Communications, Inc.','Operational','LTE 700','Montana'),
	 (10974,312,340,'National','United States of America','US',226,'MTA','Matanuska Telephone Association, Inc.','Operational','LTE 700','Alaska'),
	 (10975,312,350,'National','United States of America','US',226,'','Triangle Communication System Inc.','Operational','LTE 700','Montana'),
	 (10976,312,360,'National','United States of America','US',226,'','Wes-Tex Telecommunications, Ltd.','Unknown','Unknown','Texas');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10977,312,370,'National','United States of America','US',226,'Choice Wireless','Commnet Wireless','Operational','LTE',''),
	 (10978,312,380,'National','United States of America','US',226,'','Copper Valley Wireless','Operational','LTE 700','Alaska'),
	 (10979,312,390,'National','United States of America','US',226,'FTC Wireless','FTC Communications LLC','Operational','UMTS / LTE','South Carolina; owned by Farmers Telephone Cooperative'),
	 (10980,312,400,'National','United States of America','US',226,'Mid-Rivers Wireless','Mid-Rivers Telephone Cooperative','Operational','LTE 700','Montana'),
	 (10981,312,410,'National','United States of America','US',226,'','Eltopia Communications, LLC','Unknown','Unknown',''),
	 (10982,312,420,'National','United States of America','US',226,'','Nex-Tech Wireless','Operational','LTE 700','Kansas'),
	 (10983,312,430,'National','United States of America','US',226,'','Silver Star Communications','Operational','CDMA / LTE 700','Wyoming'),
	 (10984,312,440,'National','United States of America','US',226,'','Consolidated Telcom','Unknown','2500','North Dakota'),
	 (10985,312,450,'National','United States of America','US',226,'','Cable & Communications Corporation','Unknown','Unknown',''),
	 (10986,312,460,'National','United States of America','US',226,'','Ketchikan Public Utilities (KPU)','Operational','LTE 700','Alaska');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10987,312,470,'National','United States of America','US',226,'Carolina West Wireless','Carolina West Wireless','Operational','LTE 700','North Carolina'),
	 (10988,312,480,'National','United States of America','US',226,'Nemont','Sagebrush Cellular, Inc.','Unknown','Unknown',''),
	 (10989,312,490,'National','United States of America','US',226,'','TrustComm, Inc.','Unknown','Satellite',''),
	 (10990,312,500,'National','United States of America','US',226,'','AB Spectrum LLC','Not operational','LTE 700','MNC withdrawn'),
	 (10991,312,510,'National','United States of America','US',226,'','WUE Inc.','Unknown','CDMA / LTE','Nevada'),
	 (10992,312,520,'National','United States of America','US',226,'','ANIN','Not operational','Unknown','MNC withdrawn'),
	 (10993,312,530,'National','United States of America','US',226,'Sprint','Sprint Corporation','Operational','Unknown',''),
	 (10994,312,540,'National','United States of America','US',226,'','Broadband In Hand LLC','Not operational','Unknown','MNC withdrawn'),
	 (10995,312,550,'National','United States of America','US',226,'','Great Plains Communications, Inc.','Unknown','Unknown',''),
	 (10996,312,560,'National','United States of America','US',226,'','NHLT Inc.','Not operational','MVNO','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (10997,312,570,'National','United States of America','US',226,'Blue Wireless','Buffalo-Lake Erie Wireless Systems Co., LLC','Operational','CDMA / LTE',''),
	 (10998,312,580,'National','United States of America','US',226,'','Morgan, Lewis & Bockius LLP','Unknown','Unknown','Former Shuttle Wireless Solutions Inc., Bingham McCutchen LLP'),
	 (10999,312,590,'National','United States of America','US',226,'NMU','Northern Michigan University','Operational','LTE 2600','EBS Band (LTE band 7)'),
	 (11000,312,600,'National','United States of America','US',226,'Nemont','Sagebrush Cellular, Inc.','Unknown','Unknown',''),
	 (11001,312,610,'National','United States of America','US',226,'nTelos','nTelos Licenses, Inc.','Not operational','LTE 1900','MNC withdrawn'),
	 (11002,312,620,'National','United States of America','US',226,'','GlobeTouch Inc.','Operational','MVNO','Former Fogg Mobile, Inc.'),
	 (11003,312,630,'National','United States of America','US',226,'','NetGenuity, Inc.','Unknown','Unknown',''),
	 (11004,312,640,'National','United States of America','US',226,'Nemont','Sagebrush Cellular, Inc.','Not operational','Unknown','MNC withdrawn'),
	 (11005,312,650,'National','United States of America','US',226,'','365 Wireless LLC','Unknown','Unknown',''),
	 (11006,312,660,'National','United States of America','US',226,'nTelos','nTelos Wireless','Not operational','LTE 1900','MNC withdrawn');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11007,312,670,'National','United States of America','US',226,'FirstNet','AT&T Mobility','Operational','Unknown',''),
	 (11008,312,680,'National','United States of America','US',226,'AT&T','AT&T Mobility','Unknown','Unknown',''),
	 (11009,312,690,'National','United States of America','US',226,'','TGS, LLC','Operational','MVNO/MVNE',''),
	 (11010,312,700,'National','United States of America','US',226,'','Wireless Partners, LLC','Operational','LTE 700','Maine'),
	 (11011,312,710,'National','United States of America','US',226,'','Great North Woods Wireless LLC','Operational','LTE','New Hampshire; former Wireless Partners, LLC'),
	 (11012,312,720,'National','United States of America','US',226,'Southern LINC','Southern Communications Services','Unknown','LTE',''),
	 (11013,312,730,'National','United States of America','US',226,'','Triangle Communication System Inc.','Operational','CDMA','Montana'),
	 (11014,312,740,'National','United States of America','US',226,'Locus Telecommunications','KDDI America, Inc.','Operational','MVNO',''),
	 (11015,312,750,'National','United States of America','US',226,'','Artemis Networks LLC','Unknown','Unknown',''),
	 (11016,312,760,'National','United States of America','US',226,'ASTAC','Arctic Slope Telephone Association Cooperative','Unknown','Unknown','Alaska');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11017,312,770,'National','United States of America','US',226,'Verizon','Verizon Wireless','Unknown','Unknown',''),
	 (11018,312,780,'National','United States of America','US',226,'','Redzone Wireless','Operational','TD-LTE 2500','LTE band 41; Maine'),
	 (11019,312,790,'National','United States of America','US',226,'','Gila Electronics','Unknown','Unknown',''),
	 (11020,312,800,'National','United States of America','US',226,'','Cirrus Core Networks','Unknown','MVNO',''),
	 (11021,312,810,'National','United States of America','US',226,'BBCP','Bristol Bay Telephone Cooperative','Operational','CDMA','Alaska'),
	 (11022,312,820,'National','United States of America','US',226,'','Santel Communications Cooperative, Inc.','Unknown','Unknown','South Dakota'),
	 (11023,312,830,'National','United States of America','US',226,'','Kings County Office of Education','Operational','WiMAX','California'),
	 (11024,312,840,'National','United States of America','US',226,'','South Georgia Regional Information Technology Authority','Unknown','Unknown','Georgia'),
	 (11025,312,850,'National','United States of America','US',226,'','Onvoy Spectrum LLC','Unknown','MVNO','Former Emergency Networks LLC'),
	 (11026,312,860,'National','United States of America','US',226,'ClearTalk','Flat Wireless, LLC','Operational','CDMA / LTE 1900 / LTE 1700','Texas');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11027,312,870,'National','United States of America','US',226,'','GigSky Mobile, LLC','Operational','MVNO',''),
	 (11028,312,880,'National','United States of America','US',226,'','Albemarle County Public Schools','Unknown','Unknown',''),
	 (11029,312,890,'National','United States of America','US',226,'','Circle Gx','Unknown','Unknown',''),
	 (11030,312,900,'National','United States of America','US',226,'ClearTalk','Flat West Wireless, LLC','Operational','CDMA / LTE 1900 / LTE 1700','Arizona, California'),
	 (11031,312,910,'National','United States of America','US',226,'Appalachian Wireless','East Kentucky Network, LLC','Unknown','Unknown',''),
	 (11032,312,920,'National','United States of America','US',226,'','Northeast Wireless Networks LLC','Unknown','Unknown',''),
	 (11033,312,930,'National','United States of America','US',226,'','Hewlett-Packard Communication Services, LLC','Unknown','Unknown',''),
	 (11034,312,940,'National','United States of America','US',226,'','Webformix','Operational','Unknown','Oregon'),
	 (11035,312,950,'National','United States of America','US',226,'','Custer Telephone Co-op (CTCI)','Operational','CDMA','Idaho'),
	 (11036,312,960,'National','United States of America','US',226,'','M&A Technology, Inc.','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11037,312,970,'National','United States of America','US',226,'','IOSAZ Intellectual Property LLC','Unknown','Unknown',''),
	 (11038,312,980,'National','United States of America','US',226,'','Mark Twain Communications Company','Unknown','Unknown',''),
	 (11039,312,990,'National','United States of America','US',226,'Premier Broadband','Premier Holdings LLC','Unknown','Unknown',''),
	 (11040,313,0,'National','United States of America','US',226,'','Tennessee Wireless','Operational','Unknown',''),
	 (11041,313,10,'National','United States of America','US',226,'Bravado Wireless','Cross Wireless LLC','Unknown','Unknown','Former Sprocket Wireless'),
	 (11042,313,20,'National','United States of America','US',226,'CTC Wireless','Cambridge Telephone Company Inc.','Operational','CDMA','Idaho'),
	 (11043,313,30,'National','United States of America','US',226,'Snake River PCS','Eagle Telephone System Inc.','Operational','CDMA','Oregon'),
	 (11044,313,40,'National','United States of America','US',226,'NNTC Wireless','Nucla-Naturita Telephone Company','Operational','CDMA','Colorado'),
	 (11045,313,50,'National','United States of America','US',226,'Breakaway Wireless','Manti Tele Communications Company, Inc.','Operational','CDMA','Utah'),
	 (11046,313,60,'National','United States of America','US',226,'','Country Wireless','Operational','Unknown','Wisconsin');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11047,313,70,'National','United States of America','US',226,'','Midwest Network Solutions Hub LLC','Unknown','Unknown',''),
	 (11048,313,80,'National','United States of America','US',226,'','Speedwavz LLP','Operational','Unknown','Ohio'),
	 (11049,313,90,'National','United States of America','US',226,'','Vivint Wireless, Inc.','Operational','Unknown',''),
	 (11050,313,100,'National','United States of America','US',226,'FirstNet','700 MHz Public Safety Broadband','Unknown','LTE 700','D Block'),
	 (11051,313,110,'National','United States of America','US',226,'FirstNet','700 MHz Public Safety Broadband','Unknown','LTE','D Block for future use'),
	 (11052,313,200,'National','United States of America','US',226,'','Mercury Network Corporation','Operational','Unknown','Michigan'),
	 (11053,313,210,'National','United States of America','US',226,'AT&T','AT&T Mobility','Unknown','Unknown',''),
	 (11054,313,220,'National','United States of America','US',226,'','Custer Telephone Co-op (CTCI)','Unknown','Unknown',''),
	 (11055,313,230,'National','United States of America','US',226,'','Velocity Communications Inc.','Unknown','LTE','Montana'),
	 (11056,313,240,'National','United States of America','US',226,'Peak Internet','Fundamental Holdings, Corp.','Unknown','Unknown','Colorado');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11057,313,250,'National','United States of America','US',226,'','Imperial County Office of Education','Unknown','LTE','California'),
	 (11058,313,260,'National','United States of America','US',226,'','Expeto Wireless Inc.','Operational','MVNO',''),
	 (11059,313,270,'National','United States of America','US',226,'','Blackstar Management','Unknown','Unknown',''),
	 (11060,313,280,'National','United States of America','US',226,'','King Street Wireless, LP','Unknown','LTE 700','Fixed wireless; mobile service through U.S. Cellular'),
	 (11061,313,290,'National','United States of America','US',226,'','Gulf Coast Broadband LLC','Unknown','LTE','Fixed wireless; Louisiana'),
	 (11062,313,300,'National','United States of America','US',226,'','Cambio WiFi of Delmarva, LLC','Operational','LTE','Maryland'),
	 (11063,313,310,'National','United States of America','US',226,'','CAL.NET, Inc.','Unknown','Unknown',''),
	 (11064,313,320,'National','United States of America','US',226,'','Paladin Wireless','Unknown','LTE 3500','Fixed wireless; Georgia'),
	 (11065,313,330,'National','United States of America','US',226,'','CenturyTel Broadband Services LLC','Unknown','Unknown',''),
	 (11066,313,340,'National','United States of America','US',226,'','Dish Network','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11067,313,350,'National','United States of America','US',226,'','Dish Network','Unknown','Unknown',''),
	 (11068,313,360,'National','United States of America','US',226,'','Dish Network','Unknown','Unknown',''),
	 (11069,313,370,'National','United States of America','US',226,'','Red Truck Wireless, LLC','Unknown','Unknown','Fixed wireless'),
	 (11070,313,380,'National','United States of America','US',226,'','OptimERA Inc.','Unknown','Unknown',''),
	 (11071,313,390,'National','United States of America','US',226,'','Altice USA Wireless, Inc.','Unknown','MVNO',''),
	 (11072,313,400,'National','United States of America','US',226,'','Texoma Communications, LLC','Unknown','Unknown',''),
	 (11073,313,410,'National','United States of America','US',226,'','pdvWireless','Unknown','Unknown',''),
	 (11074,314,100,'National','United States of America','US',226,'','Reserved for Public Safety','Unknown','Unknown',''),
	 (11075,316,10,'National','United States of America','US',226,'Nextel','Nextel Communications','Not operational','iDEN 800','Merged with Sprint forming Sprint Nextel; iDEN network shut down June 2013'),
	 (11076,316,11,'National','United States of America','US',226,'Southern LINC','Southern Communications Services','Operational','iDEN 800','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11077,748,0,'National','Uruguay','UY',228,'Antel','Administración Nacional de Telecomunicaciones','Unknown','TDMA',''),
	 (11078,748,1,'National','Uruguay','UY',228,'Antel','Administración Nacional de Telecomunicaciones','Operational','GSM 1800 / UMTS 850 / UMTS 2100 / LTE 700 / LTE 1700','Former brand Ancel; LTE bands 28 / 4'),
	 (11079,748,3,'National','Uruguay','UY',228,'Antel','Administración Nacional de Telecomunicaciones','Unknown','Unknown',''),
	 (11080,748,7,'National','Uruguay','UY',228,'Movistar','Telefónica Móviles Uruguay','Operational','GSM 850 / GSM 1900 / UMTS 850 / LTE 1900','Former Movicom'),
	 (11081,748,10,'National','Uruguay','UY',228,'Claro','AM Wireless Uruguay S.A.','Operational','GSM 1900 / UMTS 1900 / LTE 1700','Former CTI Móvil'),
	 (11082,434,1,'National','Uzbekistan','UZ',229,'','Buztel','Not operational','GSM 900 / GSM 1800',''),
	 (11083,434,2,'National','Uzbekistan','UZ',229,'','Uzmacom','Not operational','GSM 900 / GSM 1800',''),
	 (11084,434,3,'National','Uzbekistan','UZ',229,'UzMobile','Uzbektelekom','Operational','CDMA2000 450','EVDO Rev A'),
	 (11085,434,4,'National','Uzbekistan','UZ',229,'Beeline','Unitel LLC','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','Former Daewoo Unitel'),
	 (11086,434,5,'National','Uzbekistan','UZ',229,'Ucell','Coscom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 2600','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11087,434,6,'National','Uzbekistan','UZ',229,'Perfectum Mobile','RUBICON WIRELESS COMMUNICATION','Operational','CDMA2000 800',''),
	 (11088,434,7,'National','Uzbekistan','UZ',229,'UMS','Universal Mobile Systems','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 800',''),
	 (11089,434,8,'National','Uzbekistan','UZ',229,'UzMobile','Uzbektelekom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (11090,541,0,'National','Vanuatu','VU',230,'AIL','ACeS International (AIL)','Operational','GSM 900',''),
	 (11091,541,1,'National','Vanuatu','VU',230,'SMILE','Telecom Vanuatu Ltd','Operational','GSM 900',''),
	 (11092,541,5,'National','Vanuatu','VU',230,'Digicel','Digicel Vanuatu Ltd','Operational','GSM 900 / UMTS 900 / LTE 700','LTE band 28'),
	 (11093,541,7,'National','Vanuatu','VU',230,'WanTok','WanTok Vanuatu Ltd','Operational','TD-LTE 2300','LTE band 40'),
	 (11094,225,0,'National','Vatican','VA',94,'','','Not operational','','The Vatican is served by Italian networks TIM, Vodafone Italy, Wind and 3'),
	 (11095,734,1,'National','Venezuela','VE',231,'Digitel','Corporacion Digitel C.A.','Not operational','GSM 900','Formerly INFONET'),
	 (11096,734,2,'National','Venezuela','VE',231,'Digitel GSM','Corporacion Digitel C.A.','Operational','GSM 900 / GSM 1800 / UMTS 900 / LTE 1800','DIGITEL-DIGICEL-INFONET Merger');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11097,734,3,'National','Venezuela','VE',231,'DirecTV','Galaxy Entertainment de Venezuela C.A.','Unknown','LTE 2600','Formerly DIGICEL'),
	 (11098,734,4,'National','Venezuela','VE',231,'movistar','Telefónica Móviles Venezuela','Operational','GSM 850 / GSM 1900 / UMTS 1900 / LTE 1700','CDMA2000 850 shut down March 2014'),
	 (11099,734,6,'National','Venezuela','VE',231,'Movilnet','Telecomunicaciones Movilnet','Operational','CDMA2000 850 / GSM 850 / UMTS 1900 / LTE 1700',''),
	 (11100,452,1,'National','Vietnam','VN',232,'MobiFone','Vietnam Mobile Telecom Services Company','Operational','GSM 900 / GSM 1800 / UMTS 2100',''),
	 (11101,452,2,'National','Vietnam','VN',232,'Vinaphone','Vietnam Telecom Services Company','Operational','GSM 900 / GSM 1800 / UMTS 900 / UMTS 2100 / LTE 1800',''),
	 (11102,452,3,'National','Vietnam','VN',232,'S-Fone','S-Telecom','Not operational','CDMA2000 800','License revoked'),
	 (11103,452,4,'National','Vietnam','VN',232,'Viettel Mobile','Viettel Telecom','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (11104,452,5,'National','Vietnam','VN',232,'Vietnamobile','Hanoi Telecom','Operational','GSM 900 / UMTS 2100',''),
	 (11105,452,6,'National','Vietnam','VN',232,'EVNTelecom','EVN Telecom','Not operational','CDMA2000 450','License revoked'),
	 (11106,452,7,'National','Vietnam','VN',232,'Gmobile','GTEL Mobile JSC','Operational','GSM 1800','Former Beeline');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11107,452,8,'National','Vietnam','VN',232,'EVNTelecom','EVN Telecom','Not operational','UMTS 2100','Acquired by Viettel Mobile'),
	 (11108,543,1,'National','Wallis and Futuna','WF',235,'Manuia','Service des Postes et Télécommunications des Îles Wallis et Futuna (SPT)','Operational','UMTS 900 / LTE',''),
	 (11109,421,1,'National','Yemen','YE',237,'SabaFon','','Operational','GSM 900',''),
	 (11110,421,2,'National','Yemen','YE',237,'MTN','Spacetel Yemen','Operational','GSM 900',''),
	 (11111,421,3,'National','Yemen','YE',237,'Yemen Mobile','Yemen Mobile','Operational','CDMA2000 800',''),
	 (11112,421,4,'National','Yemen','YE',237,'HiTS-UNITEL','Y','Operational','GSM 900',''),
	 (11113,645,1,'National','Zambia','ZM',238,'Airtel','Bharti Airtel','Operational','GSM 900 / LTE','Former Celtel (Zain)'),
	 (11114,645,2,'National','Zambia','ZM',238,'MTN','MTN Group','Operational','GSM 900 / LTE 1800','Former Telecel'),
	 (11115,645,3,'National','Zambia','ZM',238,'ZAMTEL','Zambia Telecommunications Company Ltd','Operational','GSM 900 / TD-LTE 2300',''),
	 (11116,648,1,'National','Zimbabwe','ZW',239,'Net*One','Net*One Cellular (Pvt) Ltd','Operational','GSM 900 / LTE','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11117,648,3,'National','Zimbabwe','ZW',239,'Telecel','Telecel Zimbabwe (PVT) Ltd','Operational','GSM 900',''),
	 (11118,648,4,'National','Zimbabwe','ZW',239,'Econet','Econet Wireless','Operational','GSM 900 / GSM 1800 / UMTS 2100 / LTE 1800',''),
	 (11119,901,1,'International','','',0,'ICO','ICO Satellite Management','Not operational','Satellite','MNC withdrawn'),
	 (11120,901,2,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: Sense Communications International'),
	 (11121,901,3,'International','','',0,'Iridium','','Operational','Satellite',''),
	 (11122,901,4,'International','','',0,'','Unassigned','Returned spare','Satellite','Formerly: Globalstar'),
	 (11123,901,5,'International','','',0,'','Thuraya RMSS Network','Operational','Satellite',''),
	 (11124,901,6,'International','','',0,'','Thuraya Satellite Telecommunications Company','Operational','Satellite',''),
	 (11125,901,7,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: Ellipso'),
	 (11126,901,8,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: GSM, reserved for station identification where the mobile does not have a subscription IMSI');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11127,901,9,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: Tele1 Europe'),
	 (11128,901,10,'International','','',0,'ACeS','','Not operational','Satellite','MNC withdrawn'),
	 (11129,901,11,'International','','',0,'Inmarsat','','Operational','Satellite',''),
	 (11130,901,12,'International','','',0,'Telenor','Telenor Maritime AS','Operational','GSM 1800 / LTE 800','Maritime; formerly Maritime Communications Partner (MCP)'),
	 (11131,901,13,'International','','',0,'GSM.AQ','BebbiCell AG','Operational','GSM 1800','Antarctica +88234 Network; formerly Global Networks Switzerland Inc.'),
	 (11132,901,14,'International','','',0,'AeroMobile','AeroMobile AS','Operational','GSM 1800','Air'),
	 (11133,901,15,'International','','',0,'OnAir','OnAir Switzerland Sarl','Operational','GSM 1800','Air'),
	 (11134,901,16,'International','','',0,'Cisco Jasper','Cisco Systems, Inc.','Operational','Unknown',''),
	 (11135,901,17,'International','','',0,'Navitas','JT Group Limited','Not operational','GSM 1800','Maritime; shut down in 2009'),
	 (11136,901,18,'International','','',0,'Cellular @Sea','AT&T Mobility','Operational','GSM 900 / GSM 1900 / CDMA2000 1900 / UMTS 1900','Maritime');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11137,901,19,'International','','',0,'','Vodafone Malta Maritime','Operational','GSM 900 / GSM 1800 / UMTS 2100','Maritime'),
	 (11138,901,20,'International','','',0,'','Intermatica','Unknown','Unknown',''),
	 (11139,901,21,'International','','',0,'','Wins Limited','Operational','GSM 1800','Maritime; formerly Seanet Maritime Communications'),
	 (11140,901,22,'International','','',0,'','MediaLincc Ltd','Unknown','Unknown',''),
	 (11141,901,23,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: Beeline'),
	 (11142,901,24,'International','','',0,'iNum','Voxbone','Unknown','Unknown','+883 iNum'),
	 (11143,901,25,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: In & phone'),
	 (11144,901,26,'International','','',0,'TIM@sea','Telecom Italia Mobile','Operational','GSM 1800 / GSM 1900','Maritime'),
	 (11145,901,27,'International','','',0,'OnMarine','Monaco Telecom','Operational','GSM 1800','Maritime'),
	 (11146,901,28,'International','','',0,'Vodafone','GDSP (Vodafone''s Global Data Service Platform)','Operational','Roaming SIM','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11147,901,29,'International','','',0,'Telenor','','Unknown','Unknown',''),
	 (11148,901,30,'International','','',0,'','Unassigned','Returned spare','Unknown','Formerly: Terrestar Networks'),
	 (11149,901,31,'International','','',0,'Orange','Orange S.A.','Operational','GSM 900',''),
	 (11150,901,32,'International','','',0,'Sky High','MegaFon','Operational','GSM 900','Air (Aeroflot)'),
	 (11151,901,33,'International','','',0,'','Smart Communications','Unknown','Unknown',''),
	 (11152,901,34,'International','','',0,'','tyntec GmbH','Unknown','MVNO',''),
	 (11153,901,35,'International','','',0,'','Globecomm Network Services','Operational','GSM 850','Maritime'),
	 (11154,901,36,'International','','',0,'','Azerfon','Operational','GSM 1800','Air'),
	 (11155,901,37,'International','','',0,'','Transatel','Operational','MVNO','Global SIM for Data Mobile Broadband and M2M'),
	 (11156,901,38,'International','','',0,'','Multiregional TransitTelecom (MTT)','Operational','MVNO','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11157,901,39,'International','','',0,'','MTX Connect Ltd','Operational','MVNO',''),
	 (11158,901,40,'International','','',0,'','Deutsche Telekom AG','Unknown','Unknown',''),
	 (11159,901,41,'International','','',0,'','BodyTrace Netherlands B.V.','Operational','MVNO',''),
	 (11160,901,42,'International','','',0,'','DCN Hub ehf','Unknown','Unknown',''),
	 (11161,901,43,'International','','',0,'','EMnify GmbH','Operational','MVNO',''),
	 (11162,901,44,'International','','',0,'AT&T','AT&T Inc.','Unknown','Unknown',''),
	 (11163,901,45,'International','','',0,'','Advanced Wireless Network Company Limited','Unknown','Unknown','subsidiary of Advanced Info Service'),
	 (11164,901,46,'International','','',0,'','Telecom26 AG','Operational','MVNO',''),
	 (11165,901,47,'International','','',0,'','Ooredoo','Unknown','Unknown',''),
	 (11166,901,48,'International','','',0,'Com4','Communication for Devices in Sweden AB','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11167,901,49,'International','','',0,'','Zain Kuwait','Unknown','Unknown',''),
	 (11168,901,50,'International','','',0,'','EchoStar Mobile','Unknown','Satellite','Also listed as Sawatch Limited'),
	 (11169,901,51,'International','','',0,'','VisionNG','Unknown','Unknown',''),
	 (11170,901,52,'International','','',0,'','Manx Telecom Trading Ltd.','Unknown','Unknown',''),
	 (11171,901,53,'International','','',0,'','Deutsche Telekom AG','Unknown','Unknown',''),
	 (11172,901,54,'International','','',0,'','Teleena Holding B.V.','Unknown','Unknown',''),
	 (11173,901,55,'International','','',0,'','Beezz Communication Solutions Ltd.','Unknown','Unknown',''),
	 (11174,901,56,'International','','',0,'ETSI','European Telecommunications Standards Institute','Unknown','Unknown',''),
	 (11175,901,57,'International','','',0,'','SAP','Unknown','Unknown',''),
	 (11176,901,58,'International','','',0,'BICS','Belgacom ICS SA','Unknown','Unknown','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11177,901,59,'International','','',0,'','MessageBird B.V.','Unknown','Unknown',''),
	 (11178,901,60,'International','','',0,'','OneWeb','Unknown','Unknown',''),
	 (11179,901,88,'International','','',0,'','UN Office for the Coordination of Humanitarian Affairs (OCHA)','Unknown','Unknown',''),
	 (11180,722,340,'National','Argentina','AR',10,'Personal','Personal','Operational','Unknown','Imported from TelQ'),
	 (11181,502,195,'National','Malaysia','MY',129,'Tune Talk Sdn Bhd (Celcom MVNO)','Tune Talk Sdn Bhd (Celcom MVNO)','Operational','Unknown','Imported from TelQ'),
	 (11182,714,20,'National','Panama','PA',165,'Movistar','Movistar','Operational','Unknown','Imported from TelQ'),
	 (11183,250,27,'National','Russian Federation','RU',177,'Letai','Letai','Operational','Unknown','Imported from TelQ'),
	 (11184,420,6,'National','Saudi Arabia','SA',187,'Lebara Mobile','Lebara Mobile','Operational','Unknown','Imported from TelQ'),
	 (11185,255,99,'National','Ukraine','UA',223,'Phoenix','Phoenix','Operational','Unknown','Imported from TelQ'),
	 (11186,405,915,'','','IN',99,'Etisalat DB','Haryana','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11187,405,916,'','','IN',99,'Etisalat DB','Karnataka','','',''),
	 (11188,405,931,'','','IN',99,'Etisalat DB','Madhya Pradesh','','',''),
	 (11189,405,918,'','','IN',99,'Etisalat DB','Maharashtra','','',''),
	 (11190,405,919,'','','IN',99,'Etisalat DB','Mumbai','','',''),
	 (11191,405,921,'','','IN',99,'Etisalat DB','Rajasthan','','',''),
	 (11192,405,922,'','','IN',99,'Etisalat DB','Tamilnadu','','',''),
	 (11193,405,923,'','','IN',99,'Etisalat DB','Uttar Pradesh (East)','','',''),
	 (11194,405,924,'','','IN',99,'Etisalat DB','Uttar Pradesh (West)','','',''),
	 (11195,405,882,'','','IN',99,'S TEL','Bihar','','',''),
	 (11196,405,883,'','','IN',99,'S TEL','Himachal Pradesh','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11197,405,884,'','','IN',99,'S TEL','Jammu & Kashmir','','',''),
	 (11198,405,885,'','','IN',99,'S TEL','North East','','',''),
	 (11199,405,886,'','','IN',99,'S TEL','Orissa','','',''),
	 (11200,405,887,'','','IN',99,'SISTEMA SHYAM','Andhra Pradesh','','',''),
	 (11201,405,888,'','','IN',99,'SISTEMA SHYAM','Assam','','',''),
	 (11202,405,889,'','','IN',99,'SISTEMA SHYAM','Bihar','','',''),
	 (11203,405,891,'','','IN',99,'SISTEMA SHYAM','Gujarat','','',''),
	 (11204,405,892,'','','IN',99,'SISTEMA SHYAM','Haryana','','',''),
	 (11205,405,893,'','','IN',99,'SISTEMA SHYAM','Himachal Pradesh','','',''),
	 (11206,405,894,'','','IN',99,'SISTEMA SHYAM','Jammu & Kashmir','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11207,405,895,'','','IN',99,'SISTEMA SHYAM','Karnataka','','',''),
	 (11208,405,896,'','','IN',99,'SISTEMA SHYAM','Kerala','','',''),
	 (11209,405,897,'','','IN',99,'SISTEMA SHYAM','Kolkata','','',''),
	 (11210,405,898,'','','IN',99,'SISTEMA SHYAM','Madhya Pradesh','','',''),
	 (11211,405,899,'','','IN',99,'SISTEMA SHYAM','Maharashtra','','',''),
	 (11212,405,901,'','','IN',99,'SISTEMA SHYAM','North East','','',''),
	 (11213,405,902,'','','IN',99,'SISTEMA SHYAM','Orissa','','',''),
	 (11214,405,903,'','','IN',99,'SISTEMA SHYAM','Punjab','','',''),
	 (11215,405,904,'','','IN',99,'SISTEMA SHYAM','Tamilnadu','','',''),
	 (11216,405,905,'','','IN',99,'SISTEMA SHYAM','Uttar Pradesh (East)','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11217,405,906,'','','IN',99,'SISTEMA SHYAM','Uttar Pradesh (West)','','',''),
	 (11218,405,907,'','','IN',99,'SISTEMA SHYAM','West Bengal','','',''),
	 (11219,405,876,'','','IN',99,'Unitech Wireless','Bihar','','',''),
	 (11220,405,813,'','','IN',99,'Unitech Wireless','Haryana','','',''),
	 (11221,405,814,'','','IN',99,'Unitech Wireless','Himachal Pradesh','','',''),
	 (11222,405,815,'','','IN',99,'Unitech Wireless','Jammu & Kashmir','','',''),
	 (11223,405,928,'','','IN',99,'Unitech Wireless','Madhya Pradesh','','',''),
	 (11224,405,926,'','','IN',99,'Unitech Wireless','Mumbai','','',''),
	 (11225,405,877,'','','IN',99,'Unitech Wireless','North East','','',''),
	 (11226,405,878,'','','IN',99,'Unitech Wireless','Orissa','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11227,405,816,'','','IN',99,'Unitech Wireless','Punjab','','',''),
	 (11228,405,817,'','','IN',99,'Unitech Wireless','Rajasthan','','',''),
	 (11229,405,925,'','','IN',99,'Unitech Wireless','Tamilnadu','','',''),
	 (11230,405,879,'','','IN',99,'Unitech Wireless','Uttar Pradesh (East)','','',''),
	 (11231,405,932,'','','IN',99,'VIDEOCON (HFCL)-GSM','Punjab','','',''),
	 (11232,405,823,'','','IN',99,'VIDEOCON-DATACOM','Andhra Pradesh','','',''),
	 (11233,405,825,'','','IN',99,'VIDEOCON-DATACOM','Bihar','','',''),
	 (11234,405,826,'','','IN',99,'VIDEOCON-DATACOM','Delhi','','',''),
	 (11235,405,828,'','','IN',99,'VIDEOCON-DATACOM','Haryana','','',''),
	 (11236,405,829,'','','IN',99,'VIDEOCON-DATACOM','Himachal Pradesh','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11237,405,831,'','','IN',99,'VIDEOCON-DATACOM','Karnataka','','',''),
	 (11238,405,832,'','','IN',99,'VIDEOCON-DATACOM','Kerala','','',''),
	 (11239,405,833,'','','IN',99,'VIDEOCON-DATACOM','Kolkata','','',''),
	 (11240,405,835,'','','IN',99,'VIDEOCON-DATACOM','Maharashtra','','',''),
	 (11241,405,836,'','','IN',99,'VIDEOCON-DATACOM','Mumbai','','',''),
	 (11242,405,837,'','','IN',99,'VIDEOCON-DATACOM','North East','','',''),
	 (11243,405,838,'','','IN',99,'VIDEOCON-DATACOM','Orissa','','',''),
	 (11244,405,839,'','','IN',99,'VIDEOCON-DATACOM','Rajasthan','','',''),
	 (11245,405,841,'','','IN',99,'VIDEOCON-DATACOM','Uttar Pradesh (East)','','',''),
	 (11246,405,842,'','','IN',99,'VIDEOCON-DATACOM','Uttar Pradesh (West)','','','');
INSERT INTO v2_mobile_networks (id,mcc,mnc,`type`,country_name,country_code,country_id,brand,operator,status,bands,notes) VALUES
	 (11247,405,843,'','','IN',99,'VIDEOCON-DATACOM','West Bengal','','',''),
	 (11248,364,390,'National','Bahamas','BS',16,'BTC','BTC','Operational','Unknown','Imported from TelQ'),
	 (11249,732,240,'National','Colombia','CO',47,'Logistica Flash','Logistica Flash','Operational','Unknown','Imported from TelQ'),
	 (11250,428,6,'National','Mongolia','MN',142,'G-Mobile','G-Mobile','Operational','Unknown','Imported from TelQ'),
	 (11251,358,50,'National','Saint Lucia','LC',181,'Digicel','Digicel','Operational','Unknown','Imported from TelQ');
");
    }
};
