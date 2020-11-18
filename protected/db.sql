--
-- PostgreSQL database dump
--

-- Dumped from database version 11.2
-- Dumped by pg_dump version 11.2

-- Started on 2020-11-18 02:26:07

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

ALTER TABLE IF EXISTS ONLY public.main_campaigns DROP CONSTRAINT IF EXISTS pricing_id_fk;
ALTER TABLE IF EXISTS ONLY public.main_campaigns DROP CONSTRAINT IF EXISTS platform_id_fk;
ALTER TABLE IF EXISTS ONLY public.y_operators DROP CONSTRAINT IF EXISTS operator_platorm_id_fk;
ALTER TABLE IF EXISTS ONLY public.main_campaigns DROP CONSTRAINT IF EXISTS inventory_id_fk;
ALTER TABLE IF EXISTS ONLY public.main_reports DROP CONSTRAINT IF EXISTS exterior_reports_fk2;
ALTER TABLE IF EXISTS ONLY public.main_reports DROP CONSTRAINT IF EXISTS exterior_reports_fk1;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_fk4;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_fk3;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_fk2;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_fk1;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_fk0;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_depot_fk;
ALTER TABLE IF EXISTS ONLY public.main_campaigns DROP CONSTRAINT IF EXISTS bus_size_id_fk;
ALTER TABLE IF EXISTS ONLY public.sub_media_allocation DROP CONSTRAINT IF EXISTS allocation_campaign_id_fk;
ALTER TABLE IF EXISTS ONLY public.sub_media_allocation DROP CONSTRAINT IF EXISTS allocation_bus_id_fk;
CREATE OR REPLACE VIEW public.view_campaign_status AS
SELECT
    NULL::integer AS id,
    NULL::text AS name,
    NULL::bigint AS pending,
    NULL::bigint AS approved,
    NULL::bigint AS denied,
    NULL::text AS status,
    NULL::text AS status_matrix,
    NULL::text AS status_json;
DROP INDEX IF EXISTS public.fki_buses_depot_fk;
ALTER TABLE IF EXISTS ONLY public.z_core_settings DROP CONSTRAINT IF EXISTS z_core_settings_pkey;
ALTER TABLE IF EXISTS ONLY public.y_vendors DROP CONSTRAINT IF EXISTS y_vendors_pkey;
ALTER TABLE IF EXISTS ONLY public.x_user_types DROP CONSTRAINT IF EXISTS x_user_types_pkey;
ALTER TABLE IF EXISTS ONLY public.x_report_types DROP CONSTRAINT IF EXISTS x_report_types_pkey;
ALTER TABLE IF EXISTS ONLY public.x_renewal_stage DROP CONSTRAINT IF EXISTS x_renewal_stage_pkey;
ALTER TABLE IF EXISTS ONLY public.w_vendors_operators DROP CONSTRAINT IF EXISTS w_vendors_operators_id_pk;
ALTER TABLE IF EXISTS ONLY public.main_users DROP CONSTRAINT IF EXISTS test_id_pk;
ALTER TABLE IF EXISTS ONLY public.sub_transaction_details DROP CONSTRAINT IF EXISTS sub_tran_details_id_pk;
ALTER TABLE IF EXISTS ONLY public.sub_renewal_requests DROP CONSTRAINT IF EXISTS renewal_requests_id_pk;
ALTER TABLE IF EXISTS ONLY public.y_printers DROP CONSTRAINT IF EXISTS printers_pkey;
ALTER TABLE IF EXISTS ONLY public.x_print_status DROP CONSTRAINT IF EXISTS print_status_pk;
ALTER TABLE IF EXISTS ONLY public.x_print_status DROP CONSTRAINT IF EXISTS print_status_name_key;
ALTER TABLE IF EXISTS ONLY public.x_print_stage DROP CONSTRAINT IF EXISTS print_stage_id_pk;
ALTER TABLE IF EXISTS ONLY public.main_print_orders DROP CONSTRAINT IF EXISTS print_orders_pk0;
ALTER TABLE IF EXISTS ONLY public.z_price_settings DROP CONSTRAINT IF EXISTS pricing_id_pk;
ALTER TABLE IF EXISTS ONLY public.y_platforms DROP CONSTRAINT IF EXISTS platform_id_pk;
ALTER TABLE IF EXISTS ONLY public.x_payment_status DROP CONSTRAINT IF EXISTS payment_status_pk;
ALTER TABLE IF EXISTS ONLY public.x_payment_status DROP CONSTRAINT IF EXISTS payment_status_name_key;
ALTER TABLE IF EXISTS ONLY public.y_operators DROP CONSTRAINT IF EXISTS operator_id_pk;
ALTER TABLE IF EXISTS ONLY public.main_campaigns DROP CONSTRAINT IF EXISTS new_campaign_id_pk;
ALTER TABLE IF EXISTS ONLY public.main_transactions DROP CONSTRAINT IF EXISTS main_transactions_pkey;
ALTER TABLE IF EXISTS ONLY public.y_inventory DROP CONSTRAINT IF EXISTS inventory_id_pk;
ALTER TABLE IF EXISTS ONLY public.main_reports DROP CONSTRAINT IF EXISTS exterior_reports_pk;
ALTER TABLE IF EXISTS ONLY public.z_email_settings DROP CONSTRAINT IF EXISTS email_settings_pk;
ALTER TABLE IF EXISTS ONLY public.z_email_settings DROP CONSTRAINT IF EXISTS email_settings_name_uk;
ALTER TABLE IF EXISTS ONLY public.x_transaction_status DROP CONSTRAINT IF EXISTS campaign_status_pk;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_pk;
ALTER TABLE IF EXISTS ONLY public.main_buses DROP CONSTRAINT IF EXISTS buses_number_key;
ALTER TABLE IF EXISTS ONLY public.x_bus_status DROP CONSTRAINT IF EXISTS bus_status_pk;
ALTER TABLE IF EXISTS ONLY public.x_bus_status DROP CONSTRAINT IF EXISTS bus_status_name_key;
ALTER TABLE IF EXISTS ONLY public.x_bus_sizes DROP CONSTRAINT IF EXISTS bus_sizes_id_pk;
ALTER TABLE IF EXISTS ONLY public.x_bus_depot DROP CONSTRAINT IF EXISTS bus_depot_unique;
ALTER TABLE IF EXISTS ONLY public.x_bus_depot DROP CONSTRAINT IF EXISTS bus_depot_pk;
ALTER TABLE IF EXISTS ONLY public.sub_media_allocation DROP CONSTRAINT IF EXISTS allocation_id_pk;
ALTER TABLE IF EXISTS ONLY public.sub_media_allocation DROP CONSTRAINT IF EXISTS allocation_bus_campaign_uk;
ALTER TABLE IF EXISTS public.z_price_settings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.z_email_settings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.z_core_settings ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.y_vendors ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.y_printers ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.y_platforms ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.y_operators ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.y_inventory ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_user_types ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_transaction_status ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_renewal_stage ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_print_status ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_print_stage ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_payment_status ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_bus_status ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_bus_sizes ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.x_bus_depot ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.w_vendors_operators ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.sub_transaction_details ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.sub_renewal_requests ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.sub_media_allocation ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_users ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_transactions ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_reports ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_print_orders ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_campaigns ALTER COLUMN id DROP DEFAULT;
ALTER TABLE IF EXISTS public.main_buses ALTER COLUMN id DROP DEFAULT;
DROP TABLE IF EXISTS public.x_report_types;
DROP SEQUENCE IF EXISTS public.w_vendors_operators_id_seq;
DROP VIEW IF EXISTS public.view_transactions_per_platform;
DROP VIEW IF EXISTS public.view_transactions_per_operator;
DROP VIEW IF EXISTS public.view_vendors_operators;
DROP TABLE IF EXISTS public.w_vendors_operators;
DROP VIEW IF EXISTS public.view_transactions_all;
DROP VIEW IF EXISTS public.view_pricing_options;
DROP VIEW IF EXISTS public.view_pricing_initial;
DROP VIEW IF EXISTS public.view_pricing_all;
DROP VIEW IF EXISTS public.view_payments_pending;
DROP VIEW IF EXISTS public.view_operators_platforms;
DROP VIEW IF EXISTS public.view_operators;
DROP VIEW IF EXISTS public.view_campaigns_pending;
DROP VIEW IF EXISTS public.view_campaign_status;
DROP VIEW IF EXISTS public.view_buses_interior;
DROP VIEW IF EXISTS public.view_buses_exterior;
DROP VIEW IF EXISTS public.view_buses_assigned;
DROP VIEW IF EXISTS public.view_bus_trans_options;
DROP VIEW IF EXISTS public.view_bus_summary;
DROP VIEW IF EXISTS public.view_bus_int_summary_at_a_glance;
DROP VIEW IF EXISTS public.view_bus_ext_summary_at_a_glance;
DROP VIEW IF EXISTS public.view_bus_depot_summary;
DROP SEQUENCE IF EXISTS public.vendors_id_seq;
DROP TABLE IF EXISTS public.y_vendors;
DROP SEQUENCE IF EXISTS public.users_id_seq;
DROP SEQUENCE IF EXISTS public.user_types_id_seq;
DROP TABLE IF EXISTS public.x_user_types;
DROP SEQUENCE IF EXISTS public.transactions_id_seq;
DROP SEQUENCE IF EXISTS public.transaction_details_id_seq;
DROP TABLE IF EXISTS public.sub_transaction_details;
DROP SEQUENCE IF EXISTS public.renewal_stage_id_seq;
DROP TABLE IF EXISTS public.x_renewal_stage;
DROP SEQUENCE IF EXISTS public.renewal_requests_id_seq;
DROP TABLE IF EXISTS public.sub_renewal_requests;
DROP SEQUENCE IF EXISTS public.printers_id_seq;
DROP TABLE IF EXISTS public.y_printers;
DROP SEQUENCE IF EXISTS public.print_status_id_seq;
DROP TABLE IF EXISTS public.x_print_status;
DROP SEQUENCE IF EXISTS public.print_stage_id_seq;
DROP TABLE IF EXISTS public.x_print_stage;
DROP SEQUENCE IF EXISTS public.print_orders_id_seq;
DROP SEQUENCE IF EXISTS public.pricing_id_seq;
DROP TABLE IF EXISTS public.z_price_settings;
DROP SEQUENCE IF EXISTS public.platforms_id_seq;
DROP TABLE IF EXISTS public.y_platforms;
DROP SEQUENCE IF EXISTS public.payment_status_id_seq;
DROP TABLE IF EXISTS public.x_payment_status;
DROP SEQUENCE IF EXISTS public.operators_id_seq;
DROP TABLE IF EXISTS public.y_operators;
DROP SEQUENCE IF EXISTS public.new_campaign_id_seq;
DROP TABLE IF EXISTS public.main_users;
DROP TABLE IF EXISTS public.main_transactions;
DROP TABLE IF EXISTS public.main_print_orders;
DROP TABLE IF EXISTS public.main_campaigns;
DROP SEQUENCE IF EXISTS public.inventory_id_seq;
DROP TABLE IF EXISTS public.y_inventory;
DROP SEQUENCE IF EXISTS public.exterior_reports_id_seq;
DROP TABLE IF EXISTS public.main_reports;
DROP SEQUENCE IF EXISTS public.email_settings_id_seq;
DROP TABLE IF EXISTS public.z_email_settings;
DROP SEQUENCE IF EXISTS public.core_settings_id_seq;
DROP TABLE IF EXISTS public.z_core_settings;
DROP SEQUENCE IF EXISTS public.campaign_status_id_seq;
DROP TABLE IF EXISTS public.x_transaction_status;
DROP SEQUENCE IF EXISTS public.buses_id_seq;
DROP TABLE IF EXISTS public.main_buses;
DROP SEQUENCE IF EXISTS public.bus_status_id_seq;
DROP TABLE IF EXISTS public.x_bus_status;
DROP SEQUENCE IF EXISTS public.bus_sizes_id_seq;
DROP TABLE IF EXISTS public.x_bus_sizes;
DROP SEQUENCE IF EXISTS public.bus_depot_id_seq;
DROP TABLE IF EXISTS public.x_bus_depot;
DROP SEQUENCE IF EXISTS public.allocation_id_seq;
DROP TABLE IF EXISTS public.sub_media_allocation;
SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 220 (class 1259 OID 34183)
-- Name: sub_media_allocation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_media_allocation (
    id integer NOT NULL,
    bus_id integer,
    campaign_id integer,
    active boolean DEFAULT false NOT NULL,
    created_by integer,
    ts_created timestamp with time zone DEFAULT now(),
    ts_last_update timestamp with time zone
);


ALTER TABLE public.sub_media_allocation OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 34181)
-- Name: allocation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.allocation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.allocation_id_seq OWNER TO postgres;

--
-- TOC entry 3283 (class 0 OID 0)
-- Dependencies: 219
-- Name: allocation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.allocation_id_seq OWNED BY public.sub_media_allocation.id;


--
-- TOC entry 214 (class 1259 OID 34110)
-- Name: x_bus_depot; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_depot (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.x_bus_depot OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 34108)
-- Name: bus_depot_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bus_depot_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bus_depot_id_seq OWNER TO postgres;

--
-- TOC entry 3284 (class 0 OID 0)
-- Dependencies: 213
-- Name: bus_depot_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bus_depot_id_seq OWNED BY public.x_bus_depot.id;


--
-- TOC entry 209 (class 1259 OID 33978)
-- Name: x_bus_sizes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_sizes (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_bus_sizes OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 33976)
-- Name: bus_sizes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bus_sizes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bus_sizes_id_seq OWNER TO postgres;

--
-- TOC entry 3285 (class 0 OID 0)
-- Dependencies: 208
-- Name: bus_sizes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bus_sizes_id_seq OWNED BY public.x_bus_sizes.id;


--
-- TOC entry 216 (class 1259 OID 34123)
-- Name: x_bus_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    availability boolean NOT NULL
);


ALTER TABLE public.x_bus_status OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 34121)
-- Name: bus_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bus_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bus_status_id_seq OWNER TO postgres;

--
-- TOC entry 3286 (class 0 OID 0)
-- Dependencies: 215
-- Name: bus_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bus_status_id_seq OWNED BY public.x_bus_status.id;


--
-- TOC entry 218 (class 1259 OID 34136)
-- Name: main_buses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_buses (
    id integer NOT NULL,
    number character varying NOT NULL,
    operator_id integer,
    platform_id integer,
    exterior_campaign_id integer,
    interior_campaign_id integer,
    bus_status_id integer DEFAULT 1 NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    bus_depot_id integer,
    bus_size_id integer
);


ALTER TABLE public.main_buses OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 34134)
-- Name: buses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.buses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.buses_id_seq OWNER TO postgres;

--
-- TOC entry 3287 (class 0 OID 0)
-- Dependencies: 217
-- Name: buses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.buses_id_seq OWNED BY public.main_buses.id;


--
-- TOC entry 226 (class 1259 OID 42281)
-- Name: x_transaction_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_transaction_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    admin_name character varying,
    operator_name character varying
);


ALTER TABLE public.x_transaction_status OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 42279)
-- Name: campaign_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.campaign_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.campaign_status_id_seq OWNER TO postgres;

--
-- TOC entry 3288 (class 0 OID 0)
-- Dependencies: 225
-- Name: campaign_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.campaign_status_id_seq OWNED BY public.x_transaction_status.id;


--
-- TOC entry 237 (class 1259 OID 42427)
-- Name: z_core_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.z_core_settings (
    id integer NOT NULL,
    name character varying NOT NULL,
    value character varying NOT NULL
);


ALTER TABLE public.z_core_settings OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 42425)
-- Name: core_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.core_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.core_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3289 (class 0 OID 0)
-- Dependencies: 236
-- Name: core_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.core_settings_id_seq OWNED BY public.z_core_settings.id;


--
-- TOC entry 235 (class 1259 OID 42414)
-- Name: z_email_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.z_email_settings (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    description text,
    to_value text,
    cc_value text,
    bcc_value text
);


ALTER TABLE public.z_email_settings OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 42412)
-- Name: email_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.email_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.email_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3290 (class 0 OID 0)
-- Dependencies: 234
-- Name: email_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.email_settings_id_seq OWNED BY public.z_email_settings.id;


--
-- TOC entry 233 (class 1259 OID 42392)
-- Name: main_reports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_reports (
    id integer NOT NULL,
    date date NOT NULL,
    image text,
    video text,
    comments text,
    vendor_id integer NOT NULL,
    ref_bus_id integer,
    campaign_id integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    type_id integer
);


ALTER TABLE public.main_reports OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 42390)
-- Name: exterior_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exterior_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.exterior_reports_id_seq OWNER TO postgres;

--
-- TOC entry 3291 (class 0 OID 0)
-- Dependencies: 232
-- Name: exterior_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exterior_reports_id_seq OWNED BY public.main_reports.id;


--
-- TOC entry 205 (class 1259 OID 33956)
-- Name: y_inventory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_inventory (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.y_inventory OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 33954)
-- Name: inventory_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inventory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.inventory_id_seq OWNER TO postgres;

--
-- TOC entry 3292 (class 0 OID 0)
-- Dependencies: 204
-- Name: inventory_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inventory_id_seq OWNED BY public.y_inventory.id;


--
-- TOC entry 211 (class 1259 OID 34001)
-- Name: main_campaigns; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_campaigns (
    id integer NOT NULL,
    inventory_id integer,
    platform_id integer,
    bus_size_id integer,
    price_id integer,
    quantity integer,
    start_date date NOT NULL,
    end_date date NOT NULL,
    user_id integer NOT NULL,
    vendor_id integer,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    name text,
    renewal_stage_id integer DEFAULT 1
);


ALTER TABLE public.main_campaigns OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 50814)
-- Name: main_print_orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_print_orders (
    id integer NOT NULL,
    campaign_id integer,
    printer_id integer,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    link text DEFAULT 'click here'::text,
    approved boolean DEFAULT false,
    quantity integer NOT NULL,
    comments text,
    bus_codes text
);


ALTER TABLE public.main_print_orders OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 42437)
-- Name: main_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_transactions (
    id integer NOT NULL,
    campaign_id integer NOT NULL,
    operator_id integer NOT NULL,
    quantity integer NOT NULL,
    status_id integer DEFAULT 1 NOT NULL,
    print_status_id integer DEFAULT 1 NOT NULL,
    payment_status_id integer DEFAULT 1 NOT NULL,
    created_by integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    payment_date date,
    start_date date,
    end_date date,
    price_id integer
);


ALTER TABLE public.main_transactions OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 33870)
-- Name: main_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.main_users (
    id integer NOT NULL,
    name text NOT NULL,
    reportsto integer,
    username text NOT NULL,
    password text NOT NULL,
    email character varying(250),
    user_type integer,
    vendor_id integer
);


ALTER TABLE public.main_users OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 33999)
-- Name: new_campaign_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.new_campaign_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.new_campaign_id_seq OWNER TO postgres;

--
-- TOC entry 3293 (class 0 OID 0)
-- Dependencies: 210
-- Name: new_campaign_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.new_campaign_id_seq OWNED BY public.main_campaigns.id;


--
-- TOC entry 201 (class 1259 OID 33930)
-- Name: y_operators; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_operators (
    id integer NOT NULL,
    name character varying(50),
    shortname character varying(50),
    platform_id integer,
    email character varying,
    contact_name character varying
);


ALTER TABLE public.y_operators OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 33928)
-- Name: operators_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.operators_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.operators_id_seq OWNER TO postgres;

--
-- TOC entry 3294 (class 0 OID 0)
-- Dependencies: 200
-- Name: operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.operators_id_seq OWNED BY public.y_operators.id;


--
-- TOC entry 224 (class 1259 OID 42268)
-- Name: x_payment_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_payment_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_payment_status OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 42266)
-- Name: payment_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payment_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.payment_status_id_seq OWNER TO postgres;

--
-- TOC entry 3295 (class 0 OID 0)
-- Dependencies: 223
-- Name: payment_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payment_status_id_seq OWNED BY public.x_payment_status.id;


--
-- TOC entry 199 (class 1259 OID 33919)
-- Name: y_platforms; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_platforms (
    id integer NOT NULL,
    name character varying(50),
    shortname character varying(50),
    email character varying
);


ALTER TABLE public.y_platforms OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 33917)
-- Name: platforms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.platforms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.platforms_id_seq OWNER TO postgres;

--
-- TOC entry 3296 (class 0 OID 0)
-- Dependencies: 198
-- Name: platforms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.platforms_id_seq OWNED BY public.y_platforms.id;


--
-- TOC entry 203 (class 1259 OID 33943)
-- Name: z_price_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.z_price_settings (
    id integer NOT NULL,
    platform_id integer NOT NULL,
    inventory_id integer NOT NULL,
    print_stage_id integer,
    bus_size_id integer,
    details text,
    max_limit integer,
    min_limit integer,
    price bigint,
    operator_fee bigint,
    agency_fee bigint,
    lamata_fee bigint,
    lasaa_fee bigint,
    printers_fee bigint,
    active boolean DEFAULT false NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.z_price_settings OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 33941)
-- Name: pricing_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pricing_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pricing_id_seq OWNER TO postgres;

--
-- TOC entry 3297 (class 0 OID 0)
-- Dependencies: 202
-- Name: pricing_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pricing_id_seq OWNED BY public.z_price_settings.id;


--
-- TOC entry 269 (class 1259 OID 50812)
-- Name: print_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.print_orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.print_orders_id_seq OWNER TO postgres;

--
-- TOC entry 3298 (class 0 OID 0)
-- Dependencies: 269
-- Name: print_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.print_orders_id_seq OWNED BY public.main_print_orders.id;


--
-- TOC entry 207 (class 1259 OID 33967)
-- Name: x_print_stage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_print_stage (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_print_stage OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 33965)
-- Name: print_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.print_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.print_stage_id_seq OWNER TO postgres;

--
-- TOC entry 3299 (class 0 OID 0)
-- Dependencies: 206
-- Name: print_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.print_stage_id_seq OWNED BY public.x_print_stage.id;


--
-- TOC entry 222 (class 1259 OID 42255)
-- Name: x_print_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_print_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_print_status OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 42253)
-- Name: print_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.print_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.print_status_id_seq OWNER TO postgres;

--
-- TOC entry 3300 (class 0 OID 0)
-- Dependencies: 221
-- Name: print_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.print_status_id_seq OWNED BY public.x_print_status.id;


--
-- TOC entry 268 (class 1259 OID 50803)
-- Name: y_printers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_printers (
    id integer NOT NULL,
    name text,
    passcode character varying(5),
    email text
);


ALTER TABLE public.y_printers OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 50801)
-- Name: printers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.printers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.printers_id_seq OWNER TO postgres;

--
-- TOC entry 3301 (class 0 OID 0)
-- Dependencies: 267
-- Name: printers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.printers_id_seq OWNED BY public.y_printers.id;


--
-- TOC entry 241 (class 1259 OID 42448)
-- Name: sub_renewal_requests; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_renewal_requests (
    id integer NOT NULL,
    campaign_id integer,
    created_by integer,
    ts_created timestamp with time zone,
    ts_last_update timestamp with time zone
);


ALTER TABLE public.sub_renewal_requests OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 42446)
-- Name: renewal_requests_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.renewal_requests_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.renewal_requests_id_seq OWNER TO postgres;

--
-- TOC entry 3302 (class 0 OID 0)
-- Dependencies: 240
-- Name: renewal_requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.renewal_requests_id_seq OWNED BY public.sub_renewal_requests.id;


--
-- TOC entry 245 (class 1259 OID 42473)
-- Name: x_renewal_stage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_renewal_stage (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.x_renewal_stage OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 42471)
-- Name: renewal_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.renewal_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.renewal_stage_id_seq OWNER TO postgres;

--
-- TOC entry 3303 (class 0 OID 0)
-- Dependencies: 244
-- Name: renewal_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.renewal_stage_id_seq OWNED BY public.x_renewal_stage.id;


--
-- TOC entry 243 (class 1259 OID 42456)
-- Name: sub_transaction_details; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sub_transaction_details (
    id integer NOT NULL,
    transaction_id integer NOT NULL,
    bus_id integer NOT NULL,
    created_by integer NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.sub_transaction_details OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 42454)
-- Name: transaction_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.transaction_details_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transaction_details_id_seq OWNER TO postgres;

--
-- TOC entry 3304 (class 0 OID 0)
-- Dependencies: 242
-- Name: transaction_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.transaction_details_id_seq OWNED BY public.sub_transaction_details.id;


--
-- TOC entry 238 (class 1259 OID 42435)
-- Name: transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.transactions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.transactions_id_seq OWNER TO postgres;

--
-- TOC entry 3305 (class 0 OID 0)
-- Dependencies: 238
-- Name: transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.transactions_id_seq OWNED BY public.main_transactions.id;


--
-- TOC entry 230 (class 1259 OID 42308)
-- Name: x_user_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_user_types (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_user_types OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 42306)
-- Name: user_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_types_id_seq OWNER TO postgres;

--
-- TOC entry 3306 (class 0 OID 0)
-- Dependencies: 229
-- Name: user_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_types_id_seq OWNED BY public.x_user_types.id;


--
-- TOC entry 196 (class 1259 OID 33868)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 3307 (class 0 OID 0)
-- Dependencies: 196
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.main_users.id;


--
-- TOC entry 228 (class 1259 OID 42299)
-- Name: y_vendors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_vendors (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.y_vendors OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 42297)
-- Name: vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vendors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vendors_id_seq OWNER TO postgres;

--
-- TOC entry 3308 (class 0 OID 0)
-- Dependencies: 227
-- Name: vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vendors_id_seq OWNED BY public.y_vendors.id;


--
-- TOC entry 252 (class 1259 OID 50637)
-- Name: view_bus_depot_summary; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_bus_depot_summary AS
 SELECT
        CASE
            WHEN (main_buses.bus_depot_id IS NULL) THEN '<< NO DEPOT ASSIGNED >>'::text
            ELSE ( SELECT x_bus_depot.name
               FROM public.x_bus_depot
              WHERE (x_bus_depot.id = main_buses.bus_depot_id))
        END AS depot,
    count(*) AS total_buses,
    string_agg((main_buses.number)::text, ', '::text) AS bus_codes,
    string_agg((
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN main_buses.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS good_bus_codes,
    string_agg((
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN main_buses.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS bad_bus_codes
   FROM public.main_buses
  GROUP BY main_buses.bus_depot_id;


ALTER TABLE public.view_bus_depot_summary OWNER TO postgres;

--
-- TOC entry 254 (class 1259 OID 50648)
-- Name: view_bus_ext_summary_at_a_glance; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_bus_ext_summary_at_a_glance AS
 SELECT
        CASE
            WHEN (main_buses.exterior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END AS brand_status,
    count(
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active,
    count(
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS maintenance,
    count(*) AS total,
    to_char(max(main_buses.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses
  GROUP BY
        CASE
            WHEN (main_buses.exterior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END;


ALTER TABLE public.view_bus_ext_summary_at_a_glance OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 50653)
-- Name: view_bus_int_summary_at_a_glance; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_bus_int_summary_at_a_glance AS
 SELECT
        CASE
            WHEN (main_buses.interior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END AS brand_status,
    count(
        CASE
            WHEN (main_buses.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active,
    count(
        CASE
            WHEN (main_buses.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS maintenance,
    count(*) AS total,
    to_char(max(main_buses.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses
  GROUP BY
        CASE
            WHEN (main_buses.interior_campaign_id IS NOT NULL) THEN 'BUSES - BRANDED'::text
            ELSE 'BUSES - NOT BRANDED'::text
        END;


ALTER TABLE public.view_bus_int_summary_at_a_glance OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 50642)
-- Name: view_bus_summary; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_bus_summary AS
 SELECT b.exterior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS campaign_name,
    ( SELECT ((main_campaigns.start_date || ' - '::text) || main_campaigns.end_date)
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS period,
    count(b.number) AS buses,
    count(
        CASE
            WHEN (b.bus_status_id = 1) THEN 1
            ELSE NULL::integer
        END) AS active_working,
    count(
        CASE
            WHEN (b.bus_status_id <> 1) THEN 1
            ELSE NULL::integer
        END) AS requires_maintenance,
    string_agg(DISTINCT (( SELECT x_bus_status.name
           FROM public.x_bus_status
          WHERE ((x_bus_status.id = b.bus_status_id) AND (x_bus_status.id <> 1))))::text, chr(10)) AS issues,
    string_agg((
        CASE
            WHEN (b.bus_status_id = 1) THEN b.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS good_bus_codes,
    string_agg((
        CASE
            WHEN (b.bus_status_id <> 1) THEN b.number
            ELSE NULL::character varying
        END)::text, ', '::text) AS bad_bus_codes,
    string_agg((b.number)::text, ', '::text) AS bus_codes,
    to_char(max(b.ts_last_update), 'DD Mon YYYY'::text) AS last_updated_at
   FROM public.main_buses b
  GROUP BY b.exterior_campaign_id
  ORDER BY (b.exterior_campaign_id IS NULL), ( SELECT ((main_campaigns.start_date || ' - '::text) || main_campaigns.end_date)
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) DESC;


ALTER TABLE public.view_bus_summary OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 42504)
-- Name: view_bus_trans_options; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_bus_trans_options AS
 SELECT b.id AS bus_id,
    t.id AS transaction_id,
    b.number,
    b.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = b.platform_id)) AS platform,
    b.operator_id,
    ( SELECT y_operators.name
           FROM public.y_operators
          WHERE (y_operators.id = b.operator_id)) AS operator,
    b.bus_status_id,
    ( SELECT x_bus_status.name
           FROM public.x_bus_status
          WHERE (x_bus_status.id = b.bus_status_id)) AS bus_status,
    t.quantity,
    b.exterior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.exterior_campaign_id)) AS exterior_campaign,
    b.interior_campaign_id,
    ( SELECT main_campaigns.name
           FROM public.main_campaigns
          WHERE (main_campaigns.id = b.interior_campaign_id)) AS interior_campaign
   FROM public.main_transactions t,
    public.main_buses b
  WHERE (b.operator_id = t.operator_id);


ALTER TABLE public.view_bus_trans_options OWNER TO postgres;

--
-- TOC entry 266 (class 1259 OID 50797)
-- Name: view_buses_assigned; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_buses_assigned AS
 SELECT d.id,
    d.transaction_id,
    ('BUS '::text || (b.number)::text) AS bus
   FROM public.sub_transaction_details d,
    public.main_buses b
  WHERE (b.id = d.bus_id);


ALTER TABLE public.view_buses_assigned OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 50624)
-- Name: view_buses_exterior; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_buses_exterior AS
 SELECT main_buses.id,
    main_buses.number,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.exterior_campaign_id,
    main_buses.exterior_campaign_id AS campaign_id,
    main_buses.bus_status_id,
    main_buses.bus_depot_id,
    main_buses.ts_created,
    main_buses.ts_last_update,
    ( SELECT c.vendor_id
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.exterior_campaign_id)) AS vendor_id
   FROM public.main_buses;


ALTER TABLE public.view_buses_exterior OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 50628)
-- Name: view_buses_interior; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_buses_interior AS
 SELECT main_buses.id,
    main_buses.number,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.interior_campaign_id,
    main_buses.interior_campaign_id AS campaign_id,
    main_buses.bus_status_id,
    main_buses.bus_depot_id,
    main_buses.ts_created,
    main_buses.ts_last_update,
    ( SELECT c.vendor_id
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.interior_campaign_id)) AS vendor_id
   FROM public.main_buses;


ALTER TABLE public.view_buses_interior OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 50699)
-- Name: view_campaign_status; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_campaign_status AS
SELECT
    NULL::integer AS id,
    NULL::text AS name,
    NULL::bigint AS pending,
    NULL::bigint AS approved,
    NULL::bigint AS denied,
    NULL::text AS status,
    NULL::text AS status_matrix,
    NULL::text AS status_json;


ALTER TABLE public.view_campaign_status OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 50785)
-- Name: view_campaigns_pending; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_campaigns_pending WITH (security_barrier='false') AS
 SELECT t.payment_date,
    t.start_date,
    t.end_date,
    i.name AS inventory,
    p.shortname AS platform,
    o.shortname AS operator,
    bs.name AS bus_size,
    pr.name AS print_stage,
    c.name AS campaign,
    v.name AS vendor,
    t.quantity,
    ps.price,
    ps.operator_fee,
    ps.lamata_fee,
    ps.agency_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ts.name AS transaction_status,
    xps.name AS payment_status,
    t.id AS transaction_id,
    t.payment_status_id,
    t.status_id,
    c.vendor_id,
    ps.inventory_id,
    ps.platform_id,
    t.operator_id,
    ps.bus_size_id
   FROM public.main_campaigns c,
    public.main_transactions t,
    public.z_price_settings ps,
    public.y_inventory i,
    public.y_platforms p,
    public.y_operators o,
    public.x_bus_sizes bs,
    public.x_print_stage pr,
    public.y_vendors v,
    public.x_transaction_status ts,
    public.x_payment_status xps
  WHERE ((c.id = t.campaign_id) AND (t.price_id = ps.id) AND (ps.inventory_id = i.id) AND (ps.platform_id = p.id) AND (ps.bus_size_id = bs.id) AND (ps.print_stage_id = pr.id) AND (t.operator_id = o.id) AND (c.vendor_id = v.id) AND (t.status_id = ts.id) AND (t.payment_status_id = xps.id) AND (t.payment_status_id = 2) AND (t.status_id = 4))
  ORDER BY t.id DESC;


ALTER TABLE public.view_campaigns_pending OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 50727)
-- Name: view_operators; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_operators AS
 SELECT u.id AS user_id,
    u.name,
    u.email,
    u.vendor_id,
    ut.id AS operator_id,
    ut.name AS operator
   FROM public.main_users u,
    public.x_user_types ut
  WHERE ((u.user_type = ut.id) AND (ut.id = 5));


ALTER TABLE public.view_operators OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 42485)
-- Name: view_operators_platforms; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_operators_platforms WITH (security_barrier='false') AS
 SELECT c.id AS campaign_id,
    c.platform_id AS campaign_platform_id,
    o.id AS operator_id,
    o.name AS operator_name
   FROM public.main_campaigns c,
    public.y_operators o
  WHERE (o.platform_id = c.platform_id);


ALTER TABLE public.view_operators_platforms OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 50704)
-- Name: view_payments_pending; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_payments_pending AS
 SELECT t.id AS transaction_id,
    c.id AS campaign_id,
    c.name AS campaign_name,
    t.quantity,
    xta.name AS transaction_status,
    xpr.name AS print_status,
    xpa.name AS payment_status,
    t.start_date,
    t.end_date,
    v.name AS vendor,
    o.name AS operator,
    p.name AS platform,
    i.name AS inventory,
    bs.name AS bus_size,
    pst.name AS print_stage,
    ps.price,
    ps.operator_fee,
    ps.agency_fee,
    ps.lamata_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ps.details AS price_details
   FROM public.main_transactions t,
    public.y_operators o,
    public.main_campaigns c,
    public.y_platforms p,
    public.y_inventory i,
    public.y_vendors v,
    public.z_price_settings ps,
    public.x_print_status xpr,
    public.x_payment_status xpa,
    public.x_transaction_status xta,
    public.x_bus_sizes bs,
    public.x_print_stage pst
  WHERE ((t.campaign_id = c.id) AND (t.operator_id = o.id) AND (c.inventory_id = i.id) AND (c.platform_id = p.id) AND (t.price_id = ps.id) AND (c.vendor_id = v.id) AND (t.payment_status_id = xpa.id) AND (t.print_status_id = xpr.id) AND (t.status_id = xta.id) AND (c.bus_size_id = bs.id) AND (ps.print_stage_id = pst.id) AND (t.payment_status_id = 1) AND (((now())::date - (t.ts_created)::date) < 60))
  ORDER BY t.id DESC;


ALTER TABLE public.view_payments_pending OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 42480)
-- Name: view_pricing_all; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_pricing_all AS
 SELECT p.id,
    p.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = p.platform_id)) AS platform,
    p.inventory_id,
    ( SELECT y_inventory.name
           FROM public.y_inventory
          WHERE (y_inventory.id = p.inventory_id)) AS inventory,
    p.print_stage_id,
    ( SELECT x_print_stage.name
           FROM public.x_print_stage
          WHERE (x_print_stage.id = p.print_stage_id)) AS print_stage,
    p.bus_size_id,
    ( SELECT x_bus_sizes.name
           FROM public.x_bus_sizes
          WHERE (x_bus_sizes.id = p.bus_size_id)) AS bus_size,
    p.details,
    p.max_limit,
    p.min_limit,
    p.price,
    p.operator_fee,
    p.agency_fee,
    p.lamata_fee,
    p.lasaa_fee,
    p.printers_fee,
    p.active
   FROM public.z_price_settings p;


ALTER TABLE public.view_pricing_all OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 34037)
-- Name: view_pricing_initial; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_pricing_initial AS
 SELECT p.id,
    p.platform_id,
    ( SELECT y_platforms.name
           FROM public.y_platforms
          WHERE (y_platforms.id = p.platform_id)) AS platform,
    p.inventory_id,
    ( SELECT y_inventory.name
           FROM public.y_inventory
          WHERE (y_inventory.id = p.inventory_id)) AS inventory,
    p.print_stage_id,
    ( SELECT x_print_stage.name
           FROM public.x_print_stage
          WHERE (x_print_stage.id = p.print_stage_id)) AS print_stage,
    p.bus_size_id,
    ( SELECT x_bus_sizes.name
           FROM public.x_bus_sizes
          WHERE (x_bus_sizes.id = p.bus_size_id)) AS bus_size,
    p.details,
    p.max_limit,
    p.min_limit,
    p.price,
    p.operator_fee,
    p.agency_fee,
    p.lamata_fee,
    p.lasaa_fee,
    p.printers_fee,
    p.active
   FROM public.z_price_settings p
  WHERE (p.print_stage_id = 1);


ALTER TABLE public.view_pricing_initial OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 42499)
-- Name: view_pricing_options; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_pricing_options AS
 SELECT p.id AS price_id,
    c.price_id AS requested_price_id,
    c.id AS campaign_id,
    (((p.platform)::text || ' | '::text) || p.inventory) AS platform_inventory,
    ((((((('N '::text || to_char(p.price, '999,999.99'::text)) || ' | '::text) || p.bus_size) || ' | '::text) || p.print_stage) || ' | '::text) || p.details) AS price_details
   FROM public.main_campaigns c,
    public.view_pricing_all p
  WHERE ((p.inventory_id = c.inventory_id) AND (p.platform_id = c.platform_id) AND (p.active = true))
  ORDER BY (p.id <> c.price_id);


ALTER TABLE public.view_pricing_options OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 50722)
-- Name: view_transactions_all; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_transactions_all WITH (security_barrier='false') AS
 SELECT t.payment_date,
    t.start_date,
    t.end_date,
    i.name AS inventory,
    p.shortname AS platform,
    o.shortname AS operator,
    bs.name AS bus_size,
    pr.name AS print_stage,
    c.name AS campaign,
    v.name AS vendor,
    t.quantity,
    ps.price,
    ps.operator_fee,
    ps.lamata_fee,
    ps.agency_fee,
    ps.lasaa_fee,
    ps.printers_fee,
    ts.name AS transaction_status,
    t.id AS transaction_id,
    t.status_id,
    c.vendor_id,
    ps.inventory_id,
    ps.platform_id,
    t.operator_id,
    ps.bus_size_id
   FROM public.main_campaigns c,
    public.main_transactions t,
    public.z_price_settings ps,
    public.y_inventory i,
    public.y_platforms p,
    public.y_operators o,
    public.x_bus_sizes bs,
    public.x_print_stage pr,
    public.y_vendors v,
    public.x_transaction_status ts
  WHERE ((c.id = t.campaign_id) AND (t.price_id = ps.id) AND (ps.inventory_id = i.id) AND (ps.platform_id = p.id) AND (ps.bus_size_id = bs.id) AND (ps.print_stage_id = pr.id) AND (t.operator_id = o.id) AND (c.vendor_id = v.id) AND (t.status_id = ts.id))
  ORDER BY t.id DESC;


ALTER TABLE public.view_transactions_all OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 50751)
-- Name: w_vendors_operators; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.w_vendors_operators (
    id integer NOT NULL,
    vendor_id integer,
    operator_id integer
);


ALTER TABLE public.w_vendors_operators OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 50757)
-- Name: view_vendors_operators; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_vendors_operators AS
 SELECT u.vendor_id,
    vo.operator_id,
    v.name
   FROM public.main_users u,
    public.w_vendors_operators vo,
    public.y_operators o,
    public.y_vendors v
  WHERE ((vo.vendor_id = u.vendor_id) AND (vo.vendor_id = v.id) AND (vo.operator_id = o.id))
  GROUP BY u.vendor_id, vo.operator_id, v.name;


ALTER TABLE public.view_vendors_operators OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 50768)
-- Name: view_transactions_per_operator; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_transactions_per_operator AS
 SELECT t.transaction_id,
    t.campaign,
    t.payment_date,
    t.inventory,
    t.bus_size,
    t.print_stage,
    t.quantity,
    t.operator_fee,
    t.start_date,
    t.end_date,
    t.vendor,
    t.operator,
    t.platform,
    t.transaction_status,
    t.status_id,
    t.vendor_id,
    t.inventory_id,
    t.platform_id,
    t.operator_id,
    t.bus_size_id,
    v.vendor_id AS vendor_search_id,
    v.name AS vendor_search_name
   FROM public.view_transactions_all t,
    public.view_vendors_operators v
  WHERE (t.operator_id = v.operator_id);


ALTER TABLE public.view_transactions_per_operator OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 50773)
-- Name: view_transactions_per_platform; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_transactions_per_platform AS
 SELECT t.transaction_id,
    t.campaign,
    t.payment_date,
    t.inventory,
    t.bus_size,
    t.print_stage,
    t.quantity,
    t.lamata_fee,
    t.start_date,
    t.end_date,
    t.vendor,
    t.operator,
    t.platform,
    t.transaction_status,
    t.status_id,
    t.vendor_id,
    t.inventory_id,
    t.platform_id,
    t.operator_id,
    t.bus_size_id,
    v.vendor_id AS vendor_search_id,
    v.name AS vendor_search_name
   FROM public.view_transactions_all t,
    public.view_vendors_operators v
  WHERE ((t.operator_id = v.operator_id) AND (v.vendor_id = 18));


ALTER TABLE public.view_transactions_per_platform OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 50749)
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.w_vendors_operators_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.w_vendors_operators_id_seq OWNER TO postgres;

--
-- TOC entry 3309 (class 0 OID 0)
-- Dependencies: 260
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.w_vendors_operators_id_seq OWNED BY public.w_vendors_operators.id;


--
-- TOC entry 231 (class 1259 OID 42384)
-- Name: x_report_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_report_types (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_report_types OWNER TO postgres;

--
-- TOC entry 2963 (class 2604 OID 34139)
-- Name: main_buses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses ALTER COLUMN id SET DEFAULT nextval('public.buses_id_seq'::regclass);


--
-- TOC entry 2957 (class 2604 OID 34004)
-- Name: main_campaigns id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns ALTER COLUMN id SET DEFAULT nextval('public.new_campaign_id_seq'::regclass);


--
-- TOC entry 2992 (class 2604 OID 50817)
-- Name: main_print_orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_print_orders ALTER COLUMN id SET DEFAULT nextval('public.print_orders_id_seq'::regclass);


--
-- TOC entry 2975 (class 2604 OID 42395)
-- Name: main_reports id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports ALTER COLUMN id SET DEFAULT nextval('public.exterior_reports_id_seq'::regclass);


--
-- TOC entry 2979 (class 2604 OID 42440)
-- Name: main_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_transactions ALTER COLUMN id SET DEFAULT nextval('public.transactions_id_seq'::regclass);


--
-- TOC entry 2948 (class 2604 OID 33873)
-- Name: main_users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 2967 (class 2604 OID 34186)
-- Name: sub_media_allocation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation ALTER COLUMN id SET DEFAULT nextval('public.allocation_id_seq'::regclass);


--
-- TOC entry 2985 (class 2604 OID 42451)
-- Name: sub_renewal_requests id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_renewal_requests ALTER COLUMN id SET DEFAULT nextval('public.renewal_requests_id_seq'::regclass);


--
-- TOC entry 2986 (class 2604 OID 42459)
-- Name: sub_transaction_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_transaction_details ALTER COLUMN id SET DEFAULT nextval('public.transaction_details_id_seq'::regclass);


--
-- TOC entry 2990 (class 2604 OID 50754)
-- Name: w_vendors_operators id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.w_vendors_operators ALTER COLUMN id SET DEFAULT nextval('public.w_vendors_operators_id_seq'::regclass);


--
-- TOC entry 2961 (class 2604 OID 34113)
-- Name: x_bus_depot id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot ALTER COLUMN id SET DEFAULT nextval('public.bus_depot_id_seq'::regclass);


--
-- TOC entry 2956 (class 2604 OID 33981)
-- Name: x_bus_sizes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_sizes ALTER COLUMN id SET DEFAULT nextval('public.bus_sizes_id_seq'::regclass);


--
-- TOC entry 2962 (class 2604 OID 34126)
-- Name: x_bus_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status ALTER COLUMN id SET DEFAULT nextval('public.bus_status_id_seq'::regclass);


--
-- TOC entry 2971 (class 2604 OID 42271)
-- Name: x_payment_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status ALTER COLUMN id SET DEFAULT nextval('public.payment_status_id_seq'::regclass);


--
-- TOC entry 2955 (class 2604 OID 33970)
-- Name: x_print_stage id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_stage ALTER COLUMN id SET DEFAULT nextval('public.print_stage_id_seq'::regclass);


--
-- TOC entry 2970 (class 2604 OID 42258)
-- Name: x_print_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status ALTER COLUMN id SET DEFAULT nextval('public.print_status_id_seq'::regclass);


--
-- TOC entry 2989 (class 2604 OID 42476)
-- Name: x_renewal_stage id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_renewal_stage ALTER COLUMN id SET DEFAULT nextval('public.renewal_stage_id_seq'::regclass);


--
-- TOC entry 2972 (class 2604 OID 42284)
-- Name: x_transaction_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_transaction_status ALTER COLUMN id SET DEFAULT nextval('public.campaign_status_id_seq'::regclass);


--
-- TOC entry 2974 (class 2604 OID 42311)
-- Name: x_user_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_user_types ALTER COLUMN id SET DEFAULT nextval('public.user_types_id_seq'::regclass);


--
-- TOC entry 2954 (class 2604 OID 33959)
-- Name: y_inventory id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_inventory ALTER COLUMN id SET DEFAULT nextval('public.inventory_id_seq'::regclass);


--
-- TOC entry 2950 (class 2604 OID 33933)
-- Name: y_operators id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators ALTER COLUMN id SET DEFAULT nextval('public.operators_id_seq'::regclass);


--
-- TOC entry 2949 (class 2604 OID 33922)
-- Name: y_platforms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_platforms ALTER COLUMN id SET DEFAULT nextval('public.platforms_id_seq'::regclass);


--
-- TOC entry 2991 (class 2604 OID 50806)
-- Name: y_printers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_printers ALTER COLUMN id SET DEFAULT nextval('public.printers_id_seq'::regclass);


--
-- TOC entry 2973 (class 2604 OID 42302)
-- Name: y_vendors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_vendors ALTER COLUMN id SET DEFAULT nextval('public.vendors_id_seq'::regclass);


--
-- TOC entry 2978 (class 2604 OID 42430)
-- Name: z_core_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_core_settings ALTER COLUMN id SET DEFAULT nextval('public.core_settings_id_seq'::regclass);


--
-- TOC entry 2977 (class 2604 OID 42417)
-- Name: z_email_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings ALTER COLUMN id SET DEFAULT nextval('public.email_settings_id_seq'::regclass);


--
-- TOC entry 2951 (class 2604 OID 33946)
-- Name: z_price_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_price_settings ALTER COLUMN id SET DEFAULT nextval('public.pricing_id_seq'::regclass);


--
-- TOC entry 3244 (class 0 OID 34136)
-- Dependencies: 218
-- Data for Name: main_buses; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.main_buses VALUES (102, '102246', 2, 2, 204, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (97, '102226', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (96, '102225', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (95, '102222', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (94, '102221', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (93, '102220', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (92, '102217', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (91, '102216', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (90, '102215', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (89, '102213', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (88, '102212', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (87, '102210', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (86, '102194', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (85, '102168', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (84, '102163', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (83, '102157', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (82, '102127', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (81, '102112', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (80, '102108', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (79, '102102', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (78, '102095', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (77, '102092', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 3, 1);
INSERT INTO public.main_buses VALUES (76, '102077', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (75, '102065', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (74, '102055', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (73, '102042', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (72, '102040', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (71, '102034', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (70, '102031', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (69, '102030', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (68, '102025', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (67, '101296', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (66, '101291', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (65, '101280', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (64, '101268', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (63, '101266', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (62, '101260', 2, 2, NULL, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 5, 1);
INSERT INTO public.main_buses VALUES (101, '102244', 2, 2, 204, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (100, '102241', 2, 2, 204, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (99, '102231', 2, 2, 204, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);
INSERT INTO public.main_buses VALUES (98, '102228', 2, 2, 204, NULL, 1, '2020-11-17 12:54:12.861584+00', '2020-11-17 12:54:12.861584+00', 4, 1);


--
-- TOC entry 3238 (class 0 OID 34001)
-- Dependencies: 211
-- Data for Name: main_campaigns; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.main_campaigns VALUES (131, 1, 1, 1, 9, 16, '2020-11-17', '2020-12-17', 0, 1, '2020-11-10 08:34:50.772751+00', '2020-11-10 08:34:50.772751+00', 'Yoyo', 1);
INSERT INTO public.main_campaigns VALUES (196, 1, 2, 1, 1, 10, '2020-11-19', '2020-12-19', 0, 1, '2020-11-10 16:27:51.216941+00', '2020-11-10 16:27:51.216941+00', 'Sailors Campaign', 1);
INSERT INTO public.main_campaigns VALUES (200, 1, 1, 1, 9, 7, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:18:49.06322+00', '2020-11-11 11:18:49.06322+00', 'Test Campaign', 1);
INSERT INTO public.main_campaigns VALUES (203, 1, 2, 1, 22, 80, '2020-11-18', '2020-12-18', 0, 2, '2020-11-14 14:28:32.120225+00', '2020-11-14 14:28:32.120225+00', 'Corn Flakes', 1);
INSERT INTO public.main_campaigns VALUES (3, 1, 1, 1, 9, 10, '2020-10-18', '2020-10-18', 0, NULL, '2020-10-18 00:00:00+00', '2020-10-18 00:00:00+00', NULL, 1);
INSERT INTO public.main_campaigns VALUES (11, 1, 1, 1, 9, 34, '2020-10-27', '2020-11-26', 1, NULL, '2020-10-24 09:56:40.945427+00', '2020-10-24 09:56:40.945427+00', 'xxd', 1);
INSERT INTO public.main_campaigns VALUES (12, 3, 1, 1, 17, 10, '2020-10-26', '2020-12-03', 1, 1, '2020-10-24 10:09:28.547463+00', '2020-10-24 10:09:28.547463+00', 'Hat Trick', 1);
INSERT INTO public.main_campaigns VALUES (13, 1, 1, 1, 9, 10, '2020-10-26', '2020-11-25', 1, 1, '2020-10-24 10:32:53.018443+00', '2020-10-24 10:32:53.018443+00', 'jnkj', 1);
INSERT INTO public.main_campaigns VALUES (197, 1, 1, 1, 9, 7, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:14:19.240129+00', '2020-11-11 11:14:19.240129+00', 'Test Campaign', 1);
INSERT INTO public.main_campaigns VALUES (201, 1, 1, 1, 9, 7, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:21:08.230348+00', '2020-11-11 11:21:08.230348+00', 'Test Campaign', 1);
INSERT INTO public.main_campaigns VALUES (204, 1, 2, 1, 22, 10, '2020-11-17', '2020-12-17', 0, 1, '2020-11-15 23:42:22.82101+00', '2020-11-15 23:42:22.82101+00', 'Bet9ja Campaign', 1);
INSERT INTO public.main_campaigns VALUES (14, 3, 2, 1, 14, 60, '2020-10-26', '2020-11-25', 1, 1, '2020-10-24 10:33:41.512202+00', '2020-10-24 10:33:41.512202+00', 'jnlk', 1);
INSERT INTO public.main_campaigns VALUES (15, 3, 1, 1, 17, 10, '2020-10-27', '2020-11-26', 1, 1, '2020-10-24 10:36:21.18195+00', '2020-10-24 10:36:21.18195+00', 'Hat Trick', 1);
INSERT INTO public.main_campaigns VALUES (16, 1, 1, 1, 9, 15, '2020-10-26', '2020-11-25', 1, 1, '2020-10-25 22:00:46.760993+00', '2020-10-25 22:00:46.760993+00', 'Milo VM', 1);
INSERT INTO public.main_campaigns VALUES (17, 1, 2, 1, 1, 15, '2020-10-26', '2020-11-25', 1, 1, '2020-10-25 22:03:09.692978+00', '2020-10-25 22:03:09.692978+00', 'Bournvita Promo', 1);
INSERT INTO public.main_campaigns VALUES (18, 3, 2, 1, 14, 56, '2020-10-28', '2020-11-27', 4, 2, '2020-10-26 04:51:27.620253+00', '2020-10-26 04:51:27.620253+00', 'Indomie Bonanza', 1);
INSERT INTO public.main_campaigns VALUES (19, 1, 1, 1, 9, 10, '2020-10-29', '2020-11-28', 4, 2, '2020-10-26 05:02:52.436905+00', '2020-10-26 05:02:52.436905+00', 'October Campaign', 1);
INSERT INTO public.main_campaigns VALUES (20, 2, 2, 2, 7, 13, '2020-10-30', '2020-11-29', 4, 2, '2020-10-26 05:04:19.113305+00', '2020-10-26 05:04:19.113305+00', 'Spectranet Promo', 1);
INSERT INTO public.main_campaigns VALUES (21, 2, 1, 1, 11, 50, '2020-10-31', '2020-11-30', 4, 2, '2020-10-26 06:30:34.923226+00', '2020-10-26 06:30:34.923226+00', 'Test Interior Promo', 1);
INSERT INTO public.main_campaigns VALUES (23, 1, 2, 2, 3, 15, '2020-11-11', '2020-12-11', -1, 1, '2020-11-01 07:12:31.628319+00', '2020-11-01 07:12:31.628319+00', 'CWAY Water Campaign', 1);
INSERT INTO public.main_campaigns VALUES (24, 1, 2, 1, 1, 12, '2020-11-03', '2020-12-03', 1, 1, '2020-11-01 07:15:48.574831+00', '2020-11-01 07:15:48.574831+00', 'CWAY Water Campaign 1', 1);
INSERT INTO public.main_campaigns VALUES (25, 1, 1, 1, 9, 18, '2020-11-02', '2020-12-02', 1, 1, '2020-11-01 07:50:54.038081+00', '2020-11-01 07:50:54.038081+00', 'CWAY Water Campaign 2', 1);
INSERT INTO public.main_campaigns VALUES (26, 2, 2, 1, 5, 31, '2020-11-05', '2020-12-05', 1, 1, '2020-11-01 08:23:20.82266+00', '2020-11-01 08:23:20.82266+00', 'CWAY Water Campaign 3', 1);
INSERT INTO public.main_campaigns VALUES (27, 1, 2, 1, 1, 6, '2020-11-12', '2020-12-12', 1, 1, '2020-11-01 08:24:39.171195+00', '2020-11-01 08:24:39.171195+00', 'CWAY Water Campaign 4', 1);
INSERT INTO public.main_campaigns VALUES (28, 1, 1, 1, 9, 7, '2020-11-19', '2020-12-19', 1, 1, '2020-11-01 08:35:56.410841+00', '2020-11-01 08:35:56.410841+00', 'CWAY Water Campaign 5', 1);
INSERT INTO public.main_campaigns VALUES (22, 1, 1, 1, 9, 43, '2020-10-30', '2020-11-29', 1, 1, '2020-10-29 00:00:00+00', '2020-10-29 00:00:00+00', 'New Campaign Y', 1);
INSERT INTO public.main_campaigns VALUES (29, 1, 1, 1, 9, 60, '2020-11-11', '2020-12-11', 1, 1, '2020-11-01 10:30:13.325647+00', '2020-11-01 10:30:13.325647+00', 'Sparwasser Campaign 1', 1);
INSERT INTO public.main_campaigns VALUES (30, 1, 1, 1, 9, 60, '2020-11-11', '2020-12-11', 1, 1, '2020-11-01 10:35:47.990432+00', '2020-11-01 10:35:47.990432+00', 'Sparwasser Campaign 1', 1);
INSERT INTO public.main_campaigns VALUES (31, 1, 1, 1, 9, 60, '2020-11-11', '2020-12-11', 1, 1, '2020-11-01 10:36:10.214314+00', '2020-11-01 10:36:10.214314+00', 'Sparwasser Campaign 1', 1);
INSERT INTO public.main_campaigns VALUES (32, 1, 1, 1, 9, 60, '2020-11-11', '2020-12-11', 1, 1, '2020-11-01 10:36:14.068378+00', '2020-11-01 10:36:14.068378+00', 'Sparwasser Campaign 1', 1);
INSERT INTO public.main_campaigns VALUES (33, 1, 1, 1, 9, 4, '2020-11-04', '2020-12-04', 1, 1, '2020-11-01 10:37:06.548313+00', '2020-11-01 10:37:06.548313+00', 'XYZ', 1);
INSERT INTO public.main_campaigns VALUES (34, 1, 1, 1, 9, 4, '2020-11-04', '2020-12-04', 1, 1, '2020-11-01 10:47:04.646395+00', '2020-11-01 10:47:04.646395+00', 'XYZ', 1);
INSERT INTO public.main_campaigns VALUES (35, 1, 1, 1, 9, 4, '2020-11-04', '2020-12-04', 1, 1, '2020-11-01 10:48:37.181608+00', '2020-11-01 10:48:37.181608+00', 'XYZ', 1);
INSERT INTO public.main_campaigns VALUES (36, 1, 1, 1, 9, 4, '2020-11-04', '2020-12-04', 1, 1, '2020-11-01 10:49:40.956479+00', '2020-11-01 10:49:40.956479+00', 'XYZ', 1);
INSERT INTO public.main_campaigns VALUES (37, 1, 1, 1, 9, 5, '2020-11-12', '2020-12-12', 1, 1, '2020-11-01 11:10:06.16851+00', '2020-11-01 11:10:06.16851+00', 'FATHERS DAY Campaign', 1);
INSERT INTO public.main_campaigns VALUES (39, 1, 1, 1, 9, 2, '2020-11-11', '2020-12-11', 0, 1, '2020-11-03 12:33:53.797284+00', '2020-11-03 12:33:53.797284+00', 'Baygon Campaign', 1);
INSERT INTO public.main_campaigns VALUES (40, 2, 1, 1, 11, 20, '2020-11-20', '2020-12-20', 0, 1, '2020-11-03 12:46:01.925199+00', '2020-11-03 12:46:01.925199+00', 'Samsung SuperBowl', 1);
INSERT INTO public.main_campaigns VALUES (41, 1, 1, 1, 9, 15, '2020-11-18', '2020-12-18', 0, 3, '2020-11-04 05:50:23.729373+00', '2020-11-04 05:50:23.729373+00', 'Intel Promo', 1);
INSERT INTO public.main_campaigns VALUES (198, 1, 1, 1, 9, 7, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:15:51.047272+00', '2020-11-11 11:15:51.047272+00', 'Test Campaign', 1);
INSERT INTO public.main_campaigns VALUES (202, 1, 2, 1, 1, 3, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:28:52.964703+00', '2020-11-11 11:28:52.964703+00', 'Max Limited (Large)', 1);
INSERT INTO public.main_campaigns VALUES (205, 1, 2, 1, 22, 15, '2020-11-26', '2020-12-26', 0, 1, '2020-11-16 14:21:58.233947+00', '2020-11-16 14:21:58.233947+00', 'Yoyo', 1);
INSERT INTO public.main_campaigns VALUES (199, 1, 1, 1, 9, 7, '2020-11-18', '2020-12-18', 0, 1, '2020-11-11 11:16:46.149271+00', '2020-11-11 11:16:46.149271+00', 'Test Campaign', 1);
INSERT INTO public.main_campaigns VALUES (206, 1, 1, 1, 9, 10, '2020-11-18', '2020-12-18', 0, 1, '2020-11-16 16:39:16.214133+00', '2020-11-16 16:39:16.214133+00', 'Yore', 1);
INSERT INTO public.main_campaigns VALUES (121, 1, 1, 1, 9, 10, '2020-11-20', '2020-12-20', 0, 1, '2020-11-04 08:31:41.244053+00', '2020-11-04 08:31:41.244053+00', 'TP3 Campaign', 1);
INSERT INTO public.main_campaigns VALUES (122, 1, 1, 1, 9, 10, '2020-11-20', '2020-12-20', 0, 1, '2020-11-04 08:32:08.598825+00', '2020-11-04 08:32:08.598825+00', 'TP3 Campaign', 1);
INSERT INTO public.main_campaigns VALUES (123, 1, 1, 1, 9, 10, '2020-11-20', '2020-12-20', 0, 1, '2020-11-04 08:37:17.976895+00', '2020-11-04 08:37:17.976895+00', 'TP3 Campaign', 1);
INSERT INTO public.main_campaigns VALUES (124, 1, 1, 1, 9, 15, '2020-11-11', '2020-12-11', 0, 1, '2020-11-04 08:48:18.691378+00', '2020-11-04 08:48:18.691378+00', 'arc media', 1);
INSERT INTO public.main_campaigns VALUES (129, 1, 2, 1, 1, 6, '2020-11-15', '2020-12-15', 0, 1, '2020-11-06 12:01:42.403136+00', '2020-11-06 12:01:42.403136+00', 'Investment One', 1);
INSERT INTO public.main_campaigns VALUES (130, 3, 2, 1, 16, 150, '2020-11-06', '2020-12-06', 0, 1, '2020-11-06 12:37:02.651344+00', '2020-11-06 12:37:02.651344+00', NULL, 1);
INSERT INTO public.main_campaigns VALUES (126, 2, 2, 1, 5, 10, '2020-11-18', '2020-12-18', 0, 2, '2020-11-04 00:00:00+00', '2020-11-04 00:00:00+00', 'Parrot Campaign', 4);
INSERT INTO public.main_campaigns VALUES (125, 1, 2, 1, 1, 16, '2020-11-18', '2020-12-18', 0, 1, '2020-11-04 00:00:00+00', '2020-11-04 00:00:00+00', 'ABC Transport 1', 5);
INSERT INTO public.main_campaigns VALUES (128, 1, 2, 1, 1, 50, '2020-11-12', '2020-12-12', 0, 1, '2020-11-04 00:00:00+00', '2020-11-04 00:00:00+00', 'Guinness Promo 2', 3);
INSERT INTO public.main_campaigns VALUES (127, 1, 1, 1, 9, 20, '2020-11-05', '2020-12-05', 0, 1, '2020-11-04 00:00:00+00', '2020-11-04 00:00:00+00', 'Guinness Promo', 2);


--
-- TOC entry 3277 (class 0 OID 50814)
-- Dependencies: 270
-- Data for Name: main_print_orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.main_print_orders VALUES (1, 196, 4, '2020-11-11 03:22:29.760338+00', 'click here', false, 10, NULL, NULL);
INSERT INTO public.main_print_orders VALUES (2, 204, 5, '2020-11-17 15:48:52.531622+00', 'click here', false, 10, NULL, NULL);


--
-- TOC entry 3259 (class 0 OID 42392)
-- Dependencies: 233
-- Data for Name: main_reports; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3265 (class 0 OID 42437)
-- Dependencies: 239
-- Data for Name: main_transactions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.main_transactions VALUES (1, 27, 3, 10, 1, 1, 1, -1, '2020-11-01 16:30:35.603565+00', '2020-11-01 16:30:35.603565+00', '2020-11-01', '2020-11-05', '2020-12-05', 3);
INSERT INTO public.main_transactions VALUES (11, 36, 1, 50, 1, 1, 1, -1, '2020-11-03 09:20:59.308078+00', '2020-11-03 09:20:59.308078+00', '2020-11-05', NULL, '2020-12-12', 10);
INSERT INTO public.main_transactions VALUES (12, 37, 1, 12, 1, 1, 1, -1, '2020-11-03 09:39:02.123436+00', '2020-11-03 09:39:02.123436+00', '2020-11-03', NULL, NULL, 9);
INSERT INTO public.main_transactions VALUES (13, 21, 1, 40, 1, 1, 1, -1, '2020-11-03 12:57:09.850259+00', '2020-11-03 12:57:09.850259+00', '2020-11-03', NULL, NULL, 12);
INSERT INTO public.main_transactions VALUES (24, 196, 2, 10, 4, 2, 2, 11, '2020-11-10 16:47:50.644342+00', '2020-11-10 16:47:50.644342+00', NULL, '2020-11-20', '2020-12-20', 1);
INSERT INTO public.main_transactions VALUES (25, 202, 2, 3, 2, 2, 2, 11, '2020-11-11 11:50:32.113846+00', '2020-11-11 11:50:32.113846+00', NULL, '2020-11-18', '2020-12-18', 1);
INSERT INTO public.main_transactions VALUES (26, 204, 2, 10, 1, 1, 1, 11, '2020-11-16 07:00:29.240659+00', '2020-11-16 07:00:29.240659+00', '2020-11-17', '2020-11-17', '2020-12-17', 22);
INSERT INTO public.main_transactions VALUES (27, 206, 1, 10, 1, 1, 1, 11, '2020-11-17 16:12:23.861009+00', '2020-11-17 16:12:23.861009+00', '2020-11-18', NULL, NULL, 9);
INSERT INTO public.main_transactions VALUES (28, 204, 2, 15, 1, 1, 1, 11, '2020-11-17 16:14:16.225692+00', '2020-11-17 16:14:16.225692+00', '2020-11-19', '2020-11-26', '2020-12-26', 22);
INSERT INTO public.main_transactions VALUES (14, 21, 1, 10, 1, 2, 2, -1, '2020-11-03 12:58:54.448445+00', '2020-11-03 12:58:54.448445+00', '2020-11-03', '2020-11-19', NULL, 11);
INSERT INTO public.main_transactions VALUES (15, 127, 1, 20, 1, 1, 1, 11, '2020-11-04 13:15:48.692671+00', '2020-11-04 13:15:48.692671+00', '2020-11-04', '2020-11-05', '2020-12-05', 9);
INSERT INTO public.main_transactions VALUES (16, 128, 2, 20, 1, 1, 1, -1, '2020-11-04 13:24:13.922479+00', '2020-11-04 13:24:13.922479+00', '2020-11-04', '2020-11-12', '2020-12-12', 1);
INSERT INTO public.main_transactions VALUES (17, 128, 3, 20, 1, 1, 1, -1, '2020-11-04 13:24:58.987066+00', '2020-11-04 13:24:58.987066+00', '2020-11-04', '2020-11-12', '2020-12-12', 1);
INSERT INTO public.main_transactions VALUES (18, 128, 4, 10, 1, 1, 1, -1, '2020-11-04 13:25:34.249122+00', '2020-11-04 13:25:34.249122+00', '2020-11-04', '2020-11-12', '2020-12-12', 1);
INSERT INTO public.main_transactions VALUES (19, 128, 3, 8, 1, 1, 1, -1, '2020-11-04 13:28:58.799252+00', '2020-11-04 13:28:58.799252+00', '2020-12-12', '2020-12-13', '2021-01-12', 2);
INSERT INTO public.main_transactions VALUES (21, 129, 3, 3, 1, 2, 2, -1, '2020-11-06 12:11:23.166464+00', '2020-11-06 12:11:23.166464+00', '2020-11-06', '2020-11-15', '2020-12-15', 1);
INSERT INTO public.main_transactions VALUES (29, 202, 2, 12, 1, 1, 1, 11, '2020-11-17 17:37:36.72684+00', '2020-11-17 17:37:36.72684+00', '2020-11-19', '2020-11-26', '2020-12-26', 23);
INSERT INTO public.main_transactions VALUES (8, 37, 1, 55, 4, 1, 1, -1, '2020-11-02 23:21:15.994869+00', '2020-11-02 23:21:15.994869+00', '2020-11-02', '2020-11-11', '2020-12-11', 9);
INSERT INTO public.main_transactions VALUES (7, 37, 1, 55, 2, 1, 1, -1, '2020-11-02 23:21:08.571811+00', '2020-11-02 23:21:08.571811+00', '2020-11-02', '2020-11-11', '2020-12-11', 9);
INSERT INTO public.main_transactions VALUES (3, 37, 1, 10, 3, 1, 1, -1, '2020-11-02 10:19:21.954539+00', '2020-11-02 10:19:21.954539+00', '2020-11-02', '2020-11-18', '2020-12-18', 9);
INSERT INTO public.main_transactions VALUES (23, 125, 3, 16, 3, 1, 1, -1, '2020-11-08 08:24:01.021885+00', '2020-11-08 08:24:01.021885+00', '2020-11-08', '2020-11-18', '2020-12-18', 3);
INSERT INTO public.main_transactions VALUES (10, 27, 2, 10, 2, 1, 2, -1, '2020-11-03 00:57:57.82445+00', '2020-11-03 00:57:57.82445+00', NULL, NULL, NULL, 3);
INSERT INTO public.main_transactions VALUES (9, 27, 2, 22, 4, 1, 1, -1, '2020-11-02 23:22:24.146408+00', '2020-11-02 23:22:24.146408+00', '2020-11-02', NULL, NULL, 1);
INSERT INTO public.main_transactions VALUES (22, 126, 2, 10, 1, 1, 1, -1, '2020-11-08 08:22:36.315503+00', '2020-11-08 08:22:36.315503+00', '2020-11-12', '2019-06-20', '2019-07-20', 5);
INSERT INTO public.main_transactions VALUES (20, 129, 2, 3, 1, 1, 1, -1, '2020-11-06 12:10:11.95866+00', '2020-11-06 12:10:11.95866+00', '2020-11-06', '2020-11-15', '2020-12-15', 1);


--
-- TOC entry 3224 (class 0 OID 33870)
-- Dependencies: 197
-- Data for Name: main_users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.main_users VALUES (18, 'Test LBSL', NULL, 'lbsl', '1234', 'lbsl@abc.com', 5, 17);
INSERT INTO public.main_users VALUES (17, 'Test Lamata', NULL, 'lamata', '1234', 'lamata@abc.com', 6, 18);
INSERT INTO public.main_users VALUES (16, 'Test TSL', NULL, 'tsl', '1234', 'operator@abc.com', 5, 16);
INSERT INTO public.main_users VALUES (14, 'Test Reports Manager', NULL, 'reportman', '1234', 'ademola.shasanya@valuemedia.com.ng', 4, 15);
INSERT INTO public.main_users VALUES (13, 'Test Fleet Manager', NULL, 'fleetman', '1234', 'ademola.shasanya@valuemedia.com.ng', 3, 15);
INSERT INTO public.main_users VALUES (12, 'Test Accounts Manager', NULL, 'accman', '1234', 'ademola.shasanya@valuemedia.com.ng', 2, 15);
INSERT INTO public.main_users VALUES (11, 'Test Campaign Manager', NULL, 'campman', '1234', 'ademola.shasanya@valuemedia.com.ng', 1, 15);
INSERT INTO public.main_users VALUES (10, 'Frank', 15, 'frank', 'frank', 'frank@frank.com', 0, 1);
INSERT INTO public.main_users VALUES (9, 'rocklane', 15, 'rocklane', '1234', 'rocklane@abc.com', 0, 6);
INSERT INTO public.main_users VALUES (8, 'ninthday', 15, 'ninthday', '1234', 'ninthday@abc.com', 0, 12);
INSERT INTO public.main_users VALUES (7, 'dsl', 15, 'dsl', '1234', 'test@test.com', 0, 3);
INSERT INTO public.main_users VALUES (6, 'bluebird', 15, 'bluebird', '1234', 'bluebird@abc.com', 0, 5);
INSERT INTO public.main_users VALUES (5, 'Toyosi', 15, 'valuemedia', '1234', 'valuemedia@abc.com', 0, 1);
INSERT INTO public.main_users VALUES (4, 'Olamide', 15, 'provision', '1234', 'provision@abc.com', 0, 2);
INSERT INTO public.main_users VALUES (1, 'Ademola', 15, 'adeshas', '1234', 'adeshas@gmail.com', 0, 1);
INSERT INTO public.main_users VALUES (-1, 'Admin', NULL, 'admin', 'oehjowruh8wehhweio2244esq', 'admin@abc.com', -1, NULL);
INSERT INTO public.main_users VALUES (3, 'Test Primero LBR', NULL, 'primerolbr', '1234', 'lamata@abc.com', 5, 19);
INSERT INTO public.main_users VALUES (2, 'Test Primero', NULL, 'primero', '1234', 'primero@abc.com', 5, 14);
INSERT INTO public.main_users VALUES (19, 'Test Print Manager', NULL, 'printman', '1234', 'ademola.shasanya@valuemedia.com.ng', 7, 15);
INSERT INTO public.main_users VALUES (20, 'Dokun Balogun', 15, 'provisions', '1234', 'dbalogun@provisionads.com', 0, 2);
INSERT INTO public.main_users VALUES (21, 'Jeleel Atunwa', 15, 'ninthdayglobal', '1234', 'ninthdayglobal@gmail.com', 0, 12);
INSERT INTO public.main_users VALUES (23, 'Rocklane', 15, 'adedeji', '1234', 'adedeji@rocklaneassociates.com', 0, 6);
INSERT INTO public.main_users VALUES (25, 'UlotMedia', 15, 'leye.morafa', '1234', 'leye.morafa@ulotmedia.com', 0, 20);
INSERT INTO public.main_users VALUES (22, 'UlotMedia', 15, 'ulotmediamail', '1234', 'ulotmediamail@gmail.com', 0, 20);
INSERT INTO public.main_users VALUES (24, 'Wale Makinde', 15, 'wale.makinde', '1234', 'wale.makinde@n-guagegroup.com', 0, 21);


--
-- TOC entry 3246 (class 0 OID 34183)
-- Dependencies: 220
-- Data for Name: sub_media_allocation; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3267 (class 0 OID 42448)
-- Dependencies: 241
-- Data for Name: sub_renewal_requests; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3269 (class 0 OID 42456)
-- Dependencies: 243
-- Data for Name: sub_transaction_details; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.sub_transaction_details VALUES (1, 9, 3, -1, '2020-11-02 23:34:21.353751+00', '2020-11-02 23:34:21.353751+00');
INSERT INTO public.sub_transaction_details VALUES (2, 12, 2, -1, '2020-11-03 09:46:20.069315+00', '2020-11-03 09:46:20.069315+00');
INSERT INTO public.sub_transaction_details VALUES (8, 12, 2, -1, '2020-11-03 10:11:27.145921+00', '2020-11-03 10:11:27.145921+00');
INSERT INTO public.sub_transaction_details VALUES (9, 14, 2, -1, '2020-11-03 12:59:40.338948+00', '2020-11-03 12:59:40.338948+00');
INSERT INTO public.sub_transaction_details VALUES (10, 14, 5, -1, '2020-11-03 13:04:11.067994+00', '2020-11-03 13:04:11.067994+00');
INSERT INTO public.sub_transaction_details VALUES (11, 14, 11, -1, '2020-11-03 13:13:28.396188+00', '2020-11-03 13:13:28.396188+00');
INSERT INTO public.sub_transaction_details VALUES (12, 19, 36, -1, '2020-11-04 13:31:27.948234+00', '2020-11-04 13:31:27.948234+00');
INSERT INTO public.sub_transaction_details VALUES (13, 19, 9, -1, '2020-11-04 13:31:27.948234+00', '2020-11-04 13:31:27.948234+00');
INSERT INTO public.sub_transaction_details VALUES (14, 19, 37, -1, '2020-11-04 13:31:27.948234+00', '2020-11-04 13:31:27.948234+00');
INSERT INTO public.sub_transaction_details VALUES (15, 19, 38, -1, '2020-11-04 13:31:27.948234+00', '2020-11-04 13:31:27.948234+00');
INSERT INTO public.sub_transaction_details VALUES (16, 19, 44, -1, '2020-11-04 13:31:27.948234+00', '2020-11-04 13:31:27.948234+00');
INSERT INTO public.sub_transaction_details VALUES (17, 20, 30, -1, '2020-11-06 12:18:34.47773+00', '2020-11-06 12:18:34.47773+00');
INSERT INTO public.sub_transaction_details VALUES (18, 20, 23, -1, '2020-11-06 12:18:34.47773+00', '2020-11-06 12:18:34.47773+00');
INSERT INTO public.sub_transaction_details VALUES (19, 20, 8, -1, '2020-11-06 12:18:34.47773+00', '2020-11-06 12:18:34.47773+00');
INSERT INTO public.sub_transaction_details VALUES (20, 21, 9, -1, '2020-11-10 07:23:16.690643+00', '2020-11-10 07:23:16.690643+00');
INSERT INTO public.sub_transaction_details VALUES (21, 21, 36, -1, '2020-11-10 07:23:16.690643+00', '2020-11-10 07:23:16.690643+00');
INSERT INTO public.sub_transaction_details VALUES (22, 21, 37, -1, '2020-11-10 07:23:16.690643+00', '2020-11-10 07:23:16.690643+00');
INSERT INTO public.sub_transaction_details VALUES (23, 21, 38, -1, '2020-11-10 07:23:16.690643+00', '2020-11-10 07:23:16.690643+00');
INSERT INTO public.sub_transaction_details VALUES (24, 21, 39, -1, '2020-11-10 07:23:16.690643+00', '2020-11-10 07:23:16.690643+00');
INSERT INTO public.sub_transaction_details VALUES (25, 25, 23, 13, '2020-11-11 12:17:56.79044+00', '2020-11-11 12:17:56.79044+00');
INSERT INTO public.sub_transaction_details VALUES (26, 25, 31, 13, '2020-11-11 12:17:56.79044+00', '2020-11-11 12:17:56.79044+00');
INSERT INTO public.sub_transaction_details VALUES (27, 25, 25, 13, '2020-11-11 12:17:56.79044+00', '2020-11-11 12:17:56.79044+00');


--
-- TOC entry 3273 (class 0 OID 50751)
-- Dependencies: 261
-- Data for Name: w_vendors_operators; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.w_vendors_operators VALUES (1, 16, 2);
INSERT INTO public.w_vendors_operators VALUES (2, 17, 3);
INSERT INTO public.w_vendors_operators VALUES (3, 18, 2);
INSERT INTO public.w_vendors_operators VALUES (4, 18, 3);
INSERT INTO public.w_vendors_operators VALUES (5, 18, 4);
INSERT INTO public.w_vendors_operators VALUES (7, 19, 4);
INSERT INTO public.w_vendors_operators VALUES (6, 14, 1);


--
-- TOC entry 3240 (class 0 OID 34110)
-- Dependencies: 214
-- Data for Name: x_bus_depot; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_bus_depot VALUES (1, 'OJOTA / MILE 12');
INSERT INTO public.x_bus_depot VALUES (2, 'MAJIDUN');
INSERT INTO public.x_bus_depot VALUES (3, 'OSHODI - AYOBO');
INSERT INTO public.x_bus_depot VALUES (4, 'OSHODI - ABULE - EGBA');
INSERT INTO public.x_bus_depot VALUES (5, 'IKOTUN - IKEJA');


--
-- TOC entry 3236 (class 0 OID 33978)
-- Dependencies: 209
-- Data for Name: x_bus_sizes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_bus_sizes VALUES (1, 'Large');
INSERT INTO public.x_bus_sizes VALUES (2, 'Medium');


--
-- TOC entry 3242 (class 0 OID 34123)
-- Dependencies: 216
-- Data for Name: x_bus_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_bus_status VALUES (1, 'Active &amp; Working', true);
INSERT INTO public.x_bus_status VALUES (2, 'Spray Painting Unit', false);
INSERT INTO public.x_bus_status VALUES (4, 'Vulcanizing Unit', false);
INSERT INTO public.x_bus_status VALUES (5, 'Clutch / Mechanical Unit', false);
INSERT INTO public.x_bus_status VALUES (6, 'Wheel Hotness / Brake Unit', false);
INSERT INTO public.x_bus_status VALUES (7, 'Others / Mechanical Unit', false);
INSERT INTO public.x_bus_status VALUES (8, 'Auto / Electrical Unit', false);
INSERT INTO public.x_bus_status VALUES (9, 'Air Conditional Unit', false);
INSERT INTO public.x_bus_status VALUES (10, 'Fire Accident', false);
INSERT INTO public.x_bus_status VALUES (11, 'Glass / Mirror Accessories', false);
INSERT INTO public.x_bus_status VALUES (12, 'Body Work / Accidents', false);
INSERT INTO public.x_bus_status VALUES (13, 'Audio Visual unit', false);
INSERT INTO public.x_bus_status VALUES (14, 'Alignment', false);
INSERT INTO public.x_bus_status VALUES (15, 'Engine Service', false);


--
-- TOC entry 3250 (class 0 OID 42268)
-- Dependencies: 224
-- Data for Name: x_payment_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_payment_status VALUES (1, 'PENDING');
INSERT INTO public.x_payment_status VALUES (2, 'CONFIRMED');
INSERT INTO public.x_payment_status VALUES (3, 'DENIED');


--
-- TOC entry 3234 (class 0 OID 33967)
-- Dependencies: 207
-- Data for Name: x_print_stage; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_print_stage VALUES (1, 'Initial / with Print');
INSERT INTO public.x_print_stage VALUES (2, 'Renewal / without Print');


--
-- TOC entry 3248 (class 0 OID 42255)
-- Dependencies: 222
-- Data for Name: x_print_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_print_status VALUES (1, 'PENDING');
INSERT INTO public.x_print_status VALUES (2, 'APPROVED');
INSERT INTO public.x_print_status VALUES (3, 'DENIED');


--
-- TOC entry 3271 (class 0 OID 42473)
-- Dependencies: 245
-- Data for Name: x_renewal_stage; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_renewal_stage VALUES (1, 'INACTIVE');
INSERT INTO public.x_renewal_stage VALUES (2, 'RENEW');
INSERT INTO public.x_renewal_stage VALUES (4, 'RENEWAL APPROVED');
INSERT INTO public.x_renewal_stage VALUES (5, 'CANCELLED');
INSERT INTO public.x_renewal_stage VALUES (3, 'PENDING APPROVAL');


--
-- TOC entry 3257 (class 0 OID 42384)
-- Dependencies: 231
-- Data for Name: x_report_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_report_types VALUES (1, 'Commencement');
INSERT INTO public.x_report_types VALUES (2, 'Close-out');


--
-- TOC entry 3252 (class 0 OID 42281)
-- Dependencies: 226
-- Data for Name: x_transaction_status; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_transaction_status VALUES (1, 'PENDING', 'INACTIVE', 'INACTIVE');
INSERT INTO public.x_transaction_status VALUES (4, 'PENDING', 'REQUEST OPERATOR APPROVAL', 'AWAITING OPERATOR APPROVAL');
INSERT INTO public.x_transaction_status VALUES (3, 'DENIED', 'DENIED', 'DENIED');
INSERT INTO public.x_transaction_status VALUES (5, 'APPROVED EXPIRED', 'APPROVED EXPIRED', 'APPROVED EXPIRED');
INSERT INTO public.x_transaction_status VALUES (2, 'APPROVED ACTIVE', 'APPROVED ACTIVE', 'APPROVED ACTIVE');


--
-- TOC entry 3256 (class 0 OID 42308)
-- Dependencies: 230
-- Data for Name: x_user_types; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.x_user_types VALUES (-1, 'Administrator');
INSERT INTO public.x_user_types VALUES (0, 'Vendor / Partner');
INSERT INTO public.x_user_types VALUES (1, 'Campaign Manager');
INSERT INTO public.x_user_types VALUES (2, 'Accounts Manager');
INSERT INTO public.x_user_types VALUES (3, 'Fleet Manager');
INSERT INTO public.x_user_types VALUES (4, 'Reports Manager');
INSERT INTO public.x_user_types VALUES (5, 'Operator');
INSERT INTO public.x_user_types VALUES (6, 'Super Operator (Platform)');
INSERT INTO public.x_user_types VALUES (7, 'Print Manager');


--
-- TOC entry 3232 (class 0 OID 33956)
-- Dependencies: 205
-- Data for Name: y_inventory; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.y_inventory VALUES (1, 'Exterior Branding');
INSERT INTO public.y_inventory VALUES (2, 'Interior Branding');
INSERT INTO public.y_inventory VALUES (3, 'BRT TV');


--
-- TOC entry 3228 (class 0 OID 33930)
-- Dependencies: 201
-- Data for Name: y_operators; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.y_operators VALUES (2, 'Transport Services Limited', 'TSL', 2, 'test@tsl.com', 'TSL Contact');
INSERT INTO public.y_operators VALUES (3, 'Lagos Bus Services Limited', 'LBSL', 2, 'test@lbsl.com', 'LBSL Contact');
INSERT INTO public.y_operators VALUES (4, 'Primero (Lagos Bus Reform)', 'Primero LBR', 2, 'test@primerotsl.com', 'Jeleel Atunwa');
INSERT INTO public.y_operators VALUES (1, 'Primero TSL', 'Primero', 1, 'test@primerotsl.com', 'Jeleel Atunwa');


--
-- TOC entry 3226 (class 0 OID 33919)
-- Dependencies: 199
-- Data for Name: y_platforms; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.y_platforms VALUES (1, 'Primero TSL', 'Primero', NULL);
INSERT INTO public.y_platforms VALUES (2, 'Lagos Bus Reform', 'LBR - LAMATA', NULL);


--
-- TOC entry 3275 (class 0 OID 50803)
-- Dependencies: 268
-- Data for Name: y_printers; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.y_printers VALUES (2, 'Rainbow', 'RA', 'rainbowooh@gmail.com; alfred@rainbowadvertisingltd.com');
INSERT INTO public.y_printers VALUES (4, 'Don Collection', 'DC', 'doncollection@gmail.com');
INSERT INTO public.y_printers VALUES (3, 'Ink Touch', 'IT', 'femiadeosun2004@yahoo.com');
INSERT INTO public.y_printers VALUES (1, 'Owl Media', 'OW', 'owlmedialimited@gmail.com');
INSERT INTO public.y_printers VALUES (5, 'DSL', 'DP', 'anu.fowler@dsl.com.ng; Nkechi.dimgbe@dsl.com.ng');
INSERT INTO public.y_printers VALUES (6, 'Test Printer', 'TP', 'Johnson.udoeka@valuemedia.com.ng');


--
-- TOC entry 3254 (class 0 OID 42299)
-- Dependencies: 228
-- Data for Name: y_vendors; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.y_vendors VALUES (1, 'ValueMedia');
INSERT INTO public.y_vendors VALUES (2, 'Provision');
INSERT INTO public.y_vendors VALUES (3, 'DSL');
INSERT INTO public.y_vendors VALUES (4, 'SDM');
INSERT INTO public.y_vendors VALUES (5, 'Bluebird');
INSERT INTO public.y_vendors VALUES (6, 'Rocklane Associates');
INSERT INTO public.y_vendors VALUES (7, 'Dupsonia Events');
INSERT INTO public.y_vendors VALUES (8, 'Don Collections');
INSERT INTO public.y_vendors VALUES (9, 'Extradia');
INSERT INTO public.y_vendors VALUES (10, 'OOH Communication');
INSERT INTO public.y_vendors VALUES (11, 'Efull Media Tech');
INSERT INTO public.y_vendors VALUES (12, 'Night Day Global Concepts');
INSERT INTO public.y_vendors VALUES (13, 'Test Vendor');
INSERT INTO public.y_vendors VALUES (15, 'Transit Media');
INSERT INTO public.y_vendors VALUES (16, 'TSL');
INSERT INTO public.y_vendors VALUES (17, 'LBSL');
INSERT INTO public.y_vendors VALUES (18, 'LAMATA');
INSERT INTO public.y_vendors VALUES (19, 'PRIMERO LBR');
INSERT INTO public.y_vendors VALUES (14, 'Primero TSL');
INSERT INTO public.y_vendors VALUES (20, 'U-Lot Media');
INSERT INTO public.y_vendors VALUES (21, 'N-Gauge');


--
-- TOC entry 3263 (class 0 OID 42427)
-- Dependencies: 237
-- Data for Name: z_core_settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.z_core_settings VALUES (2, 'ext_account_details', '<p><strong>Bank: </strong>Zenith Bank Plc<br />
<strong>Account Name:</strong> 434 Transit Limited<br />
<strong>Account Number (NUBAN):</strong> 1015531312</p>');
INSERT INTO public.z_core_settings VALUES (10, 'campaign_denied', '<p>Hello [x_vendor],</p>

<p>Unfortunately, Your campaign request for <strong>[x_campaign] </strong>has been <strong>Denied</strong>.</p>

<p>Please contact [x_supportemail] if you require more information.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (1, 'exterior_campaign_price', '<p>155000</p>');
INSERT INTO public.z_core_settings VALUES (16, 'campaign_approved_transitmedia', '<p>Hello Transit Media,</p>

<p>The campaign <strong>[x_campaign]</strong> for <strong>[x_vendor]</strong> has been approved.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (9, 'exterior_campaign_discount_rate', '<p>7</p>');
INSERT INTO public.z_core_settings VALUES (15, 'campaign_approved_primero', '<p>Hello Transit Media User,</p>

<p>The campaign <strong>[x_campaign]</strong> for <strong>[x_vendor]</strong> has been approved.</p>

<p>Please find invoice attached.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (7, 'new_campaign_admin', '<p>Hello Transit Media Admin,</p>

<p>A new campaign has just been created.</p>

<p>Details:</p>

<p>[x_details]</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (3, 'reminder_external_22', '<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Good day,</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please take this as a reminder that your external branding for campaign<strong> [x_campaign] </strong>will expire in [x_expiry_days] days ([x_expiry_date].).</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Kindly notify us (info@transitmedia.com.ng) if you would like to renew this campaign.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please note, the campaign will be de-branded if payment is not received within 2 days after expiry.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Regards</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Transit Media Admin</span></span></p>');
INSERT INTO public.z_core_settings VALUES (4, 'reminder_external_28', '<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Good day,</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please take this as a reminder that your external branding for campaign<strong> [x_campaign]</strong><strong> </strong>will expire in [x_expiry_days] days ([x_expiry_date].).</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Kindly notify us (info@transitmedia.com.ng) if you would like to renew this campaign.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please note, the campaign will be de-branded if payment is not received within 2 days after expiry.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Regards</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Transit Media Admin</span></span></p>');
INSERT INTO public.z_core_settings VALUES (5, 'reminder_external_30', '<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Good day,</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please take this as a reminder that your external branding for campaign<strong> [x_campaign] </strong>will expire in [x_expiry_days] days ([x_expiry_date].).</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Kindly notify us (info@transitmedia.com.ng) if you would like to renew this campaign.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Please note, the campaign will be de-branded if payment is not received within 2 days after expiry.</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Regards</span></span></p>

<p style="margin-left:0cm;margin-right:0cm;"><span style="font-size:12pt;"><span style="font-family:''Times New Roman'', serif;">Transit Media Admin</span></span></p>');
INSERT INTO public.z_core_settings VALUES (6, 'new_campaign', '<p>Hello Transit Media Agent,</p>

<p>Your campaign has just been created.</p>

<p><u><strong>Details:</strong></u></p>

<p>[x_details]</p>

<p>Kindly make payment of <strong>[x_amount]</strong> to the account number listed below.</p>

<p>[x_account_details]</p>

<p>Please send payment notification once payment has been made to info@transitmedia.com.ng.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (11, 'print_approved', '<p>Hello [x_vendor],</p>

<p>Your print request for <strong>[x_campaign] </strong>has been <strong>Approved</strong>.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (12, 'print_denied', '<p>Hello [x_vendor],</p>

<p>Your print request for <strong>[x_campaign]</strong> has been <strong>Denied</strong>.</p>

<p>Please contact [x_supportemail] if you require more information.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (14, 'print_and_payment_approved_primero', '<p>Hello Operator,<br />
<br />
Print &amp; Payment for <strong>[x_vendor]</strong>Campaign (<strong>[x_campaign]</strong>) has been <strong>Confirmed</strong>. <br />
<br />
<strong>Awaiting your Approval</strong>.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (13, 'payment_approved', '<p>Hello [x_vendor],</p>

<p>Payment for your Campaign (<strong>[x_campaign]</strong>) has been <strong>Confirmed</strong>. <br />
<br />
Your campaign is scheduled to start within 48hrs of your payment confirmation and print approval. <br />
<br />
<strong>Note: Proof of posting would be sent to you once the buses have been branded</strong>.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (18, 'ext_account_details2', '<p><strong>Bank: </strong>Guaranty Trust Bank Plc (GTBank)<br />
<strong>Account Name:</strong> 434 Transit Limited<br />
<strong>Account Number (NUBAN):</strong> 0469788506</p>');
INSERT INTO public.z_core_settings VALUES (17, 'new_exterior_campaign_report', '<p>Hello Transit Media User,</p>

<p>This is a notification that a [x_report_type] report has just been uploaded for your campaign [x_campaign_name].</p>

<p>Kindly login to <a href="http://new.transitmedia.com.ng/vendorportal">http://new.transitmedia.com.ng/vendorportal</a> to view it.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');
INSERT INTO public.z_core_settings VALUES (8, 'campaign_approved', '<p>Hello [x_vendor],</p>

<p>Your campaign request has been <strong>Approved</strong>. </p>

<p> </p>

<table border="1" cellpadding="1" cellspacing="1" style="width:500px;">
	<tbody>
		<tr>
			<td><strong>Campaign:</strong></td>
			<td>
			<p>[x_campaign]</p>
			</td>
		</tr>
		<tr>
			<td>
			<p><strong>Buses:</strong></p>
			</td>
			<td>
			<p>[x_quantity]</p>
			</td>
		</tr>
	</tbody>
</table>

<p> </p>

<p>Your campaign is scheduled to start within 48hrs of your payment confirmation and print approval. <br />
<br />
<strong>Note: Proof of posting would be sent to you once the buses have been branded</strong>.</p>

<p>Regards</p>

<p>Transit Media Admin</p>');


--
-- TOC entry 3261 (class 0 OID 42414)
-- Dependencies: 235
-- Data for Name: z_email_settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.z_email_settings VALUES (1, 'updates_to_campaign_operator', 'Print & Payment Approved. Send mail to Primero', 'jeleel.atunwa@primerotsl.com', NULL, NULL);
INSERT INTO public.z_email_settings VALUES (4, 'new_campaign_transitmedia', 'New Exterior Campaign

TM NOTIFICATION', 'info@transitmedia.com.ng', NULL, NULL);
INSERT INTO public.z_email_settings VALUES (5, 'payment_approved_vendor', 'Email to vendor that payment approval is complete

PAYMENT CONFIRMATION ({$vendor}) - TRANSIT MEDIA ADMIN', NULL, 'victoria.onuoha@transitmedia.com.ng,
info@transitmedia.com.ng', NULL);
INSERT INTO public.z_email_settings VALUES (6, 'payment_approved_operator', 'Email to Jeleel to Approve

PENDING APPROVAL - PRINT & PAYMENT CONFIRMATION ({$vendor}) - TRANSIT MEDIA', 'jeleel.atunwa@primerotsl.com', NULL, NULL);
INSERT INTO public.z_email_settings VALUES (7, 'branders_pass', 'Sending the branders pass', NULL, 'jeleel.atunwa@primerotsl.com, tamitope.lawal@transitmedia.com.ng', 'johnson.udoeka@transitmedia.com.ng');
INSERT INTO public.z_email_settings VALUES (8, 'new_report_vendor', 'Report Notification sent to Vendor', NULL, 'victoria.onuoha@transitmedia.com.ng,
info@transitmedia.com.ng', NULL);
INSERT INTO public.z_email_settings VALUES (3, 'new_campaign_vendor', 'New Exterior Campaign

VENDOR NOTIFICATION', NULL, 'info@transitmedia.com.ng', NULL);
INSERT INTO public.z_email_settings VALUES (2, 'updates_to_campaign_vendor', '1.	Campaign Denied
2.	Print Approved
3.	Print Denied
4.	Payment Approved', NULL, 'info@transitmedia.com.ng', 'toyosi.aramide@transitmedia.com.ng,
johnson.udoeka@transitmedia.com.ng');


--
-- TOC entry 3230 (class 0 OID 33943)
-- Dependencies: 203
-- Data for Name: z_price_settings; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.z_price_settings VALUES (4, 2, 1, 2, 2, 'per month per bus', NULL, NULL, 125000, 5000, 35000, 75000, 5000, 0, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (5, 2, 2, 1, 1, 'per month per bus', NULL, NULL, 80000, 5000, 20000, 40000, 0, 15000, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (6, 2, 2, 2, 1, 'per month per bus', NULL, NULL, 80000, 5000, 20000, 40000, 0, 15000, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (7, 2, 2, 1, 2, 'per month per bus', NULL, NULL, 80000, 5000, 20000, 40000, 0, 15000, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (8, 2, 2, 2, 2, 'per month per bus', NULL, NULL, 80000, 5000, 20000, 40000, 0, 15000, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (23, 2, 1, 2, 1, 'per month per bus', NULL, NULL, 185000, 33000, 35000, 88000, 10000, 0, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (24, 2, 1, 1, 2, 'per month per bus', NULL, NULL, 150000, 22500, 27500, 60000, 5000, 25000, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (9, 1, 1, 1, 1, 'per month per bus', NULL, NULL, 130000, 80000, 17000, 5000, 2500, 23000, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (10, 1, 1, 2, 1, 'per month per bus', NULL, NULL, 130000, 80000, 17000, 5000, 2500, 0, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (11, 1, 2, 1, 1, 'per month per bus', NULL, NULL, 50000, 20000, 15000, 0, 0, 15000, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (12, 1, 2, 2, 1, 'per month per bus', NULL, NULL, 50000, 20000, 15000, 0, 0, 15000, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (17, 1, 3, 1, 1, 'Standard Package - per fleet - (20 spots every 36mins)', NULL, NULL, 1000000, NULL, NULL, NULL, NULL, NULL, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (18, 1, 3, 1, 1, 'Medium Package - per fleet - (30 spots every 24mins)', NULL, NULL, 1500000, NULL, NULL, NULL, NULL, NULL, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (19, 1, 3, 1, 1, 'High Package - per fleet - (40 spots every 18mins)', NULL, NULL, 2000000, NULL, NULL, NULL, NULL, NULL, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (20, 1, 3, 1, 1, 'Very High Package - per fleet - (50 spots every 14mins)', NULL, NULL, 2500000, NULL, NULL, NULL, NULL, NULL, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (21, 1, 3, 1, 1, 'Maximum Package - per fleet - (60 spots every 12mins)', NULL, NULL, 3000000, NULL, NULL, NULL, NULL, NULL, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (13, 2, 3, 1, 1, 'per month per bus (10 - 49 buses)', 49, 10, 40000, 20000, 10000, 0, 0, 0, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (25, 2, 1, 2, 2, 'per month per bus', NULL, NULL, 125000, 22500, 27500, 60000, 5000, 0, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (26, 2, 2, 1, 1, 'per month per bus', NULL, NULL, 80000, 12000, 21000, 32000, 0, 15000, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (27, 2, 2, 2, 1, 'per month per bus', NULL, NULL, 65000, 12000, 21000, 32000, 0, 0, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (28, 2, 2, 1, 2, 'per month per bus', NULL, NULL, 50000, 7500, 12500, 32000, 0, 10000, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (29, 2, 2, 2, 2, 'per month per bus', NULL, NULL, 35000, 7500, 7500, 20000, 0, 0, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (22, 2, 1, 1, 1, 'per month per bus', NULL, NULL, 220000, 33000, 40000, 88000, 10000, 30000, true, '2020-11-14 00:00:00+00');
INSERT INTO public.z_price_settings VALUES (14, 2, 3, 1, 1, 'per month per bus (50 - 99 buses)', 99, 50, 30000, 15000, 10000, 0, 0, 0, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (15, 2, 3, 1, 1, 'per month per bus (100 - 149 buses)', 149, 100, 20000, 10000, 5000, 0, 0, 0, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (16, 2, 3, 1, 1, 'per month per bus (150 - 199 buses)', 199, 150, 10000, 5000, 2500, 0, 0, 0, true, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (1, 2, 1, 1, 1, 'per month per bus', NULL, NULL, 220000, 10000, 50000, 110000, 5000, 30000, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (2, 2, 1, 2, 1, 'per month per bus', NULL, NULL, 185000, 20000, 30000, 100000, 5000, 0, false, '2020-11-14 09:29:16.631181+00');
INSERT INTO public.z_price_settings VALUES (3, 2, 1, 1, 2, 'per month per bus', NULL, NULL, 150000, 5000, 35000, 75000, 5000, 20000, false, '2020-11-14 09:29:16.631181+00');


--
-- TOC entry 3310 (class 0 OID 0)
-- Dependencies: 219
-- Name: allocation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.allocation_id_seq', 4, true);


--
-- TOC entry 3311 (class 0 OID 0)
-- Dependencies: 213
-- Name: bus_depot_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bus_depot_id_seq', 5, true);


--
-- TOC entry 3312 (class 0 OID 0)
-- Dependencies: 208
-- Name: bus_sizes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bus_sizes_id_seq', 2, true);


--
-- TOC entry 3313 (class 0 OID 0)
-- Dependencies: 215
-- Name: bus_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bus_status_id_seq', 1, true);


--
-- TOC entry 3314 (class 0 OID 0)
-- Dependencies: 217
-- Name: buses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.buses_id_seq', 102, true);


--
-- TOC entry 3315 (class 0 OID 0)
-- Dependencies: 225
-- Name: campaign_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.campaign_status_id_seq', 5, true);


--
-- TOC entry 3316 (class 0 OID 0)
-- Dependencies: 236
-- Name: core_settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.core_settings_id_seq', 18, true);


--
-- TOC entry 3317 (class 0 OID 0)
-- Dependencies: 234
-- Name: email_settings_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.email_settings_id_seq', 1, false);


--
-- TOC entry 3318 (class 0 OID 0)
-- Dependencies: 232
-- Name: exterior_reports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.exterior_reports_id_seq', 3, true);


--
-- TOC entry 3319 (class 0 OID 0)
-- Dependencies: 204
-- Name: inventory_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.inventory_id_seq', 3, true);


--
-- TOC entry 3320 (class 0 OID 0)
-- Dependencies: 210
-- Name: new_campaign_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.new_campaign_id_seq', 206, true);


--
-- TOC entry 3321 (class 0 OID 0)
-- Dependencies: 200
-- Name: operators_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.operators_id_seq', 4, true);


--
-- TOC entry 3322 (class 0 OID 0)
-- Dependencies: 223
-- Name: payment_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payment_status_id_seq', 1, false);


--
-- TOC entry 3323 (class 0 OID 0)
-- Dependencies: 198
-- Name: platforms_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.platforms_id_seq', 2, true);


--
-- TOC entry 3324 (class 0 OID 0)
-- Dependencies: 202
-- Name: pricing_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pricing_id_seq', 29, true);


--
-- TOC entry 3325 (class 0 OID 0)
-- Dependencies: 269
-- Name: print_orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.print_orders_id_seq', 2, true);


--
-- TOC entry 3326 (class 0 OID 0)
-- Dependencies: 206
-- Name: print_stage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.print_stage_id_seq', 2, true);


--
-- TOC entry 3327 (class 0 OID 0)
-- Dependencies: 221
-- Name: print_status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.print_status_id_seq', 1, false);


--
-- TOC entry 3328 (class 0 OID 0)
-- Dependencies: 267
-- Name: printers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.printers_id_seq', 1, false);


--
-- TOC entry 3329 (class 0 OID 0)
-- Dependencies: 240
-- Name: renewal_requests_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.renewal_requests_id_seq', 1, false);


--
-- TOC entry 3330 (class 0 OID 0)
-- Dependencies: 244
-- Name: renewal_stage_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.renewal_stage_id_seq', 6, true);


--
-- TOC entry 3331 (class 0 OID 0)
-- Dependencies: 242
-- Name: transaction_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.transaction_details_id_seq', 27, true);


--
-- TOC entry 3332 (class 0 OID 0)
-- Dependencies: 238
-- Name: transactions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.transactions_id_seq', 29, true);


--
-- TOC entry 3333 (class 0 OID 0)
-- Dependencies: 229
-- Name: user_types_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_types_id_seq', 7, true);


--
-- TOC entry 3334 (class 0 OID 0)
-- Dependencies: 196
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 25, true);


--
-- TOC entry 3335 (class 0 OID 0)
-- Dependencies: 227
-- Name: vendors_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vendors_id_seq', 21, true);


--
-- TOC entry 3336 (class 0 OID 0)
-- Dependencies: 260
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.w_vendors_operators_id_seq', 7, true);


--
-- TOC entry 3026 (class 2606 OID 34200)
-- Name: sub_media_allocation allocation_bus_campaign_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_campaign_uk UNIQUE (bus_id, campaign_id);


--
-- TOC entry 3028 (class 2606 OID 34188)
-- Name: sub_media_allocation allocation_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_id_pk PRIMARY KEY (id);


--
-- TOC entry 3013 (class 2606 OID 34118)
-- Name: x_bus_depot bus_depot_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT bus_depot_pk PRIMARY KEY (id);


--
-- TOC entry 3015 (class 2606 OID 34120)
-- Name: x_bus_depot bus_depot_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT bus_depot_unique UNIQUE (name);


--
-- TOC entry 3009 (class 2606 OID 33986)
-- Name: x_bus_sizes bus_sizes_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_sizes
    ADD CONSTRAINT bus_sizes_id_pk PRIMARY KEY (id);


--
-- TOC entry 3017 (class 2606 OID 34133)
-- Name: x_bus_status bus_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT bus_status_name_key UNIQUE (name);


--
-- TOC entry 3019 (class 2606 OID 34131)
-- Name: x_bus_status bus_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT bus_status_pk PRIMARY KEY (id);


--
-- TOC entry 3021 (class 2606 OID 34149)
-- Name: main_buses buses_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_number_key UNIQUE (number);


--
-- TOC entry 3023 (class 2606 OID 34147)
-- Name: main_buses buses_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_pk PRIMARY KEY (id);


--
-- TOC entry 3038 (class 2606 OID 42289)
-- Name: x_transaction_status campaign_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_transaction_status
    ADD CONSTRAINT campaign_status_pk PRIMARY KEY (id);


--
-- TOC entry 3048 (class 2606 OID 42424)
-- Name: z_email_settings email_settings_name_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT email_settings_name_uk UNIQUE (name);


--
-- TOC entry 3050 (class 2606 OID 42422)
-- Name: z_email_settings email_settings_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT email_settings_pk PRIMARY KEY (id);


--
-- TOC entry 3046 (class 2606 OID 42401)
-- Name: main_reports exterior_reports_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_pk PRIMARY KEY (id);


--
-- TOC entry 3005 (class 2606 OID 33964)
-- Name: y_inventory inventory_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_inventory
    ADD CONSTRAINT inventory_id_pk PRIMARY KEY (id);


--
-- TOC entry 3054 (class 2606 OID 50605)
-- Name: main_transactions main_transactions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_transactions
    ADD CONSTRAINT main_transactions_pkey PRIMARY KEY (id);


--
-- TOC entry 3011 (class 2606 OID 34006)
-- Name: main_campaigns new_campaign_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT new_campaign_id_pk PRIMARY KEY (id);


--
-- TOC entry 3001 (class 2606 OID 33935)
-- Name: y_operators operator_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT operator_id_pk PRIMARY KEY (id);


--
-- TOC entry 3034 (class 2606 OID 42278)
-- Name: x_payment_status payment_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT payment_status_name_key UNIQUE (name);


--
-- TOC entry 3036 (class 2606 OID 42276)
-- Name: x_payment_status payment_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT payment_status_pk PRIMARY KEY (id);


--
-- TOC entry 2999 (class 2606 OID 33924)
-- Name: y_platforms platform_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_platforms
    ADD CONSTRAINT platform_id_pk PRIMARY KEY (id);


--
-- TOC entry 3003 (class 2606 OID 33951)
-- Name: z_price_settings pricing_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_price_settings
    ADD CONSTRAINT pricing_id_pk PRIMARY KEY (id);


--
-- TOC entry 3066 (class 2606 OID 50825)
-- Name: main_print_orders print_orders_pk0; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_print_orders
    ADD CONSTRAINT print_orders_pk0 PRIMARY KEY (id);


--
-- TOC entry 3007 (class 2606 OID 33975)
-- Name: x_print_stage print_stage_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_stage
    ADD CONSTRAINT print_stage_id_pk PRIMARY KEY (id);


--
-- TOC entry 3030 (class 2606 OID 42265)
-- Name: x_print_status print_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT print_status_name_key UNIQUE (name);


--
-- TOC entry 3032 (class 2606 OID 42263)
-- Name: x_print_status print_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT print_status_pk PRIMARY KEY (id);


--
-- TOC entry 3064 (class 2606 OID 50811)
-- Name: y_printers printers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_printers
    ADD CONSTRAINT printers_pkey PRIMARY KEY (id);


--
-- TOC entry 3056 (class 2606 OID 42453)
-- Name: sub_renewal_requests renewal_requests_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_renewal_requests
    ADD CONSTRAINT renewal_requests_id_pk PRIMARY KEY (id);


--
-- TOC entry 3058 (class 2606 OID 50607)
-- Name: sub_transaction_details sub_tran_details_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_transaction_details
    ADD CONSTRAINT sub_tran_details_id_pk PRIMARY KEY (id);


--
-- TOC entry 2997 (class 2606 OID 33878)
-- Name: main_users test_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_users
    ADD CONSTRAINT test_id_pk PRIMARY KEY (id);


--
-- TOC entry 3062 (class 2606 OID 50756)
-- Name: w_vendors_operators w_vendors_operators_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.w_vendors_operators
    ADD CONSTRAINT w_vendors_operators_id_pk PRIMARY KEY (id);


--
-- TOC entry 3060 (class 2606 OID 50711)
-- Name: x_renewal_stage x_renewal_stage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_renewal_stage
    ADD CONSTRAINT x_renewal_stage_pkey PRIMARY KEY (id);


--
-- TOC entry 3044 (class 2606 OID 50721)
-- Name: x_report_types x_report_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_report_types
    ADD CONSTRAINT x_report_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3042 (class 2606 OID 50717)
-- Name: x_user_types x_user_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_user_types
    ADD CONSTRAINT x_user_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3040 (class 2606 OID 50719)
-- Name: y_vendors y_vendors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_vendors
    ADD CONSTRAINT y_vendors_pkey PRIMARY KEY (id);


--
-- TOC entry 3052 (class 2606 OID 50676)
-- Name: z_core_settings z_core_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_core_settings
    ADD CONSTRAINT z_core_settings_pkey PRIMARY KEY (id);


--
-- TOC entry 3024 (class 1259 OID 34180)
-- Name: fki_buses_depot_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_buses_depot_fk ON public.main_buses USING btree (bus_depot_id);


--
-- TOC entry 3214 (class 2618 OID 50702)
-- Name: view_campaign_status _RETURN; Type: RULE; Schema: public; Owner: postgres
--

CREATE OR REPLACE VIEW public.view_campaign_status AS
 SELECT v.id,
    v.name,
    v.pending,
    v.approved,
    v.denied,
        CASE
            WHEN ((v.pending > 0) OR ((v.denied + v.approved) = 0)) THEN 'PENDING'::text
            ELSE
            CASE
                WHEN ((v.denied > 0) AND (v.approved = 0)) THEN 'DENIED'::text
                WHEN ((v.denied = 0) AND (v.approved > 0)) THEN 'APPROVED'::text
                ELSE 'APPROVED'::text
            END
        END AS status,
    array_to_string(ARRAY[v.approved, v.pending, v.denied], ','::text, '*'::text) AS status_matrix,
    (((((('{"approved":'::text || v.approved) || ',"pending":'::text) || v.pending) || ',"denied":'::text) || v.denied) || '}'::text) AS status_json
   FROM ( SELECT c.id,
            c.name,
            count(
                CASE
                    WHEN (t.status_id = ANY (ARRAY[1, 4])) THEN 1
                    ELSE NULL::integer
                END) AS pending,
            count(
                CASE
                    WHEN (t.status_id = ANY (ARRAY[2, 5])) THEN 1
                    ELSE NULL::integer
                END) AS approved,
            count(
                CASE
                    WHEN (t.status_id = 3) THEN 1
                    ELSE NULL::integer
                END) AS denied
           FROM (public.main_campaigns c
             LEFT JOIN public.main_transactions t ON ((c.id = t.campaign_id)))
          GROUP BY c.id) v
  ORDER BY v.pending DESC;


--
-- TOC entry 3078 (class 2606 OID 34189)
-- Name: sub_media_allocation allocation_bus_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_id_fk FOREIGN KEY (bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3079 (class 2606 OID 34194)
-- Name: sub_media_allocation allocation_campaign_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_campaign_id_fk FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3070 (class 2606 OID 34022)
-- Name: main_campaigns bus_size_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT bus_size_id_fk FOREIGN KEY (bus_size_id) REFERENCES public.x_bus_sizes(id);


--
-- TOC entry 3072 (class 2606 OID 34150)
-- Name: main_buses buses_depot_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_depot_fk FOREIGN KEY (bus_depot_id) REFERENCES public.x_bus_depot(id);


--
-- TOC entry 3074 (class 2606 OID 34160)
-- Name: main_buses buses_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_fk0 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3075 (class 2606 OID 34165)
-- Name: main_buses buses_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_fk1 FOREIGN KEY (exterior_campaign_id) REFERENCES public.main_campaigns(id) ON DELETE SET NULL;


--
-- TOC entry 3076 (class 2606 OID 34170)
-- Name: main_buses buses_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_fk2 FOREIGN KEY (interior_campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3077 (class 2606 OID 34175)
-- Name: main_buses buses_fk3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_fk3 FOREIGN KEY (bus_status_id) REFERENCES public.x_bus_status(id);


--
-- TOC entry 3073 (class 2606 OID 34155)
-- Name: main_buses buses_fk4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT buses_fk4 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3080 (class 2606 OID 42402)
-- Name: main_reports exterior_reports_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk1 FOREIGN KEY (ref_bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3081 (class 2606 OID 42407)
-- Name: main_reports exterior_reports_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk2 FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3069 (class 2606 OID 34012)
-- Name: main_campaigns inventory_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT inventory_id_fk FOREIGN KEY (inventory_id) REFERENCES public.y_inventory(id);


--
-- TOC entry 3067 (class 2606 OID 33936)
-- Name: y_operators operator_platorm_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT operator_platorm_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3068 (class 2606 OID 34007)
-- Name: main_campaigns platform_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT platform_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3071 (class 2606 OID 34027)
-- Name: main_campaigns pricing_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT pricing_id_fk FOREIGN KEY (price_id) REFERENCES public.z_price_settings(id);


-- Completed on 2020-11-18 02:26:13

--
-- PostgreSQL database dump complete
--

