--
-- PostgreSQL database dump
--

-- Dumped from database version 11.2
-- Dumped by pg_dump version 11.2

-- Started on 2020-12-09 11:57:19

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 308 (class 1259 OID 54392)
-- Name: __main_buses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.__main_buses (
    id integer,
    number character varying,
    operator_id integer,
    platform_id integer,
    exterior_campaign_id integer,
    interior_campaign_id integer,
    bus_status_id integer,
    ts_created timestamp with time zone,
    ts_last_update timestamp with time zone,
    bus_depot_id integer,
    bus_size_id integer
);


ALTER TABLE public.__main_buses OWNER TO postgres;

--
-- TOC entry 309 (class 1259 OID 54398)
-- Name: __main_campaigns; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.__main_campaigns (
    id integer,
    inventory_id integer,
    platform_id integer,
    bus_size_id integer,
    price_id integer,
    quantity integer,
    start_date date,
    end_date date,
    created_by integer,
    vendor_id integer,
    ts_created timestamp with time zone,
    ts_last_update timestamp with time zone,
    name character varying,
    renewal_stage_id integer
);


ALTER TABLE public.__main_campaigns OWNER TO postgres;

--
-- TOC entry 310 (class 1259 OID 54405)
-- Name: __main_transactions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.__main_transactions (
    id integer,
    campaign_id integer,
    operator_id integer,
    quantity integer,
    status_id integer,
    print_status_id integer,
    payment_status_id integer,
    created_by integer,
    ts_created timestamp with time zone,
    ts_last_update timestamp with time zone,
    payment_date date,
    start_date date,
    end_date date,
    price_id integer
);


ALTER TABLE public.__main_transactions OWNER TO postgres;

--
-- TOC entry 311 (class 1259 OID 54408)
-- Name: __main_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.__main_users (
    id integer,
    name text,
    reportsto integer,
    username text,
    password text,
    email character varying(250),
    user_type integer,
    vendor_id integer
);


ALTER TABLE public.__main_users OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 51412)
-- Name: bus_depot; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bus_depot (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.bus_depot OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 51418)
-- Name: bus_depot_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bus_depot_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bus_depot_id_seq OWNER TO postgres;

--
-- TOC entry 3475 (class 0 OID 0)
-- Dependencies: 199
-- Name: bus_depot_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bus_depot_id_seq OWNED BY public.bus_depot.id;


--
-- TOC entry 201 (class 1259 OID 51429)
-- Name: bus_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bus_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    availability boolean NOT NULL
);


ALTER TABLE public.bus_status OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 51435)
-- Name: bus_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bus_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.bus_status_id_seq OWNER TO postgres;

--
-- TOC entry 3476 (class 0 OID 0)
-- Dependencies: 202
-- Name: bus_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bus_status_id_seq OWNED BY public.bus_status.id;


--
-- TOC entry 200 (class 1259 OID 51420)
-- Name: buses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.buses (
    id integer NOT NULL,
    number character varying NOT NULL,
    service_provider_id integer,
    exterior_campaign_id integer,
    interior_campaign_id integer,
    bus_status_id integer DEFAULT 1 NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    bus_depot_id integer
);


ALTER TABLE public.buses OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 51456)
-- Name: buses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.buses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.buses_id_seq OWNER TO postgres;

--
-- TOC entry 3477 (class 0 OID 0)
-- Dependencies: 205
-- Name: buses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.buses_id_seq OWNED BY public.buses.id;


--
-- TOC entry 206 (class 1259 OID 51458)
-- Name: campaign_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.campaign_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.campaign_status OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 51464)
-- Name: campaign_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.campaign_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.campaign_status_id_seq OWNER TO postgres;

--
-- TOC entry 3478 (class 0 OID 0)
-- Dependencies: 207
-- Name: campaign_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.campaign_status_id_seq OWNED BY public.campaign_status.id;


--
-- TOC entry 208 (class 1259 OID 51466)
-- Name: core_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.core_settings (
    id integer NOT NULL,
    name character varying NOT NULL,
    value character varying NOT NULL
);


ALTER TABLE public.core_settings OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 51472)
-- Name: core_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.core_settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.core_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3479 (class 0 OID 0)
-- Dependencies: 209
-- Name: core_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.core_settings_id_seq OWNED BY public.core_settings.id;


--
-- TOC entry 210 (class 1259 OID 51474)
-- Name: discounts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.discounts (
    id integer NOT NULL,
    minimum integer,
    maximum integer,
    amount bigint,
    primero_fee integer
);


ALTER TABLE public.discounts OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 51477)
-- Name: discounts_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.discounts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.discounts_id_seq OWNER TO postgres;

--
-- TOC entry 3480 (class 0 OID 0)
-- Dependencies: 211
-- Name: discounts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.discounts_id_seq OWNED BY public.discounts.id;


--
-- TOC entry 212 (class 1259 OID 51479)
-- Name: email_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.email_settings (
    id integer NOT NULL,
    name character varying(60) NOT NULL,
    description text,
    to_value text,
    cc_value text,
    bcc_value text
);


ALTER TABLE public.email_settings OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 51485)
-- Name: email_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.email_settings_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.email_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3481 (class 0 OID 0)
-- Dependencies: 213
-- Name: email_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.email_settings_id_seq OWNED BY public.email_settings.id;


--
-- TOC entry 203 (class 1259 OID 51437)
-- Name: exterior_campaigns; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exterior_campaigns (
    id integer NOT NULL,
    name character varying NOT NULL,
    brand_id integer,
    start_date date NOT NULL,
    end_date date NOT NULL,
    quantity integer NOT NULL,
    created_by integer NOT NULL,
    vendor_id integer,
    status_id integer DEFAULT 1 NOT NULL,
    print_status_id integer DEFAULT 1 NOT NULL,
    payment_status_id integer DEFAULT 1 NOT NULL,
    ts_created timestamp with time zone DEFAULT now() NOT NULL,
    ts_last_update timestamp with time zone DEFAULT now() NOT NULL,
    renewal boolean DEFAULT false
);


ALTER TABLE public.exterior_campaigns OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 51487)
-- Name: exterior_campaigns_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exterior_campaigns_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.exterior_campaigns_id_seq OWNER TO postgres;

--
-- TOC entry 3482 (class 0 OID 0)
-- Dependencies: 214
-- Name: exterior_campaigns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exterior_campaigns_id_seq OWNED BY public.exterior_campaigns.id;


--
-- TOC entry 215 (class 1259 OID 51489)
-- Name: exterior_reports; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.exterior_reports (
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


ALTER TABLE public.exterior_reports OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 51496)
-- Name: exterior_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.exterior_reports_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.exterior_reports_id_seq OWNER TO postgres;

--
-- TOC entry 3483 (class 0 OID 0)
-- Dependencies: 216
-- Name: exterior_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.exterior_reports_id_seq OWNED BY public.exterior_reports.id;


--
-- TOC entry 232 (class 1259 OID 53877)
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
-- TOC entry 233 (class 1259 OID 53886)
-- Name: main_buses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_buses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_buses_id_seq OWNER TO postgres;

--
-- TOC entry 3484 (class 0 OID 0)
-- Dependencies: 233
-- Name: main_buses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_buses_id_seq OWNED BY public.main_buses.id;


--
-- TOC entry 234 (class 1259 OID 53888)
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
-- TOC entry 235 (class 1259 OID 53897)
-- Name: main_campaigns_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_campaigns_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_campaigns_id_seq OWNER TO postgres;

--
-- TOC entry 3485 (class 0 OID 0)
-- Dependencies: 235
-- Name: main_campaigns_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_campaigns_id_seq OWNED BY public.main_campaigns.id;


--
-- TOC entry 236 (class 1259 OID 53899)
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
-- TOC entry 237 (class 1259 OID 53908)
-- Name: main_print_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_print_orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_print_orders_id_seq OWNER TO postgres;

--
-- TOC entry 3486 (class 0 OID 0)
-- Dependencies: 237
-- Name: main_print_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_print_orders_id_seq OWNED BY public.main_print_orders.id;


--
-- TOC entry 238 (class 1259 OID 53910)
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
-- TOC entry 239 (class 1259 OID 53917)
-- Name: main_reports_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_reports_id_seq OWNER TO postgres;

--
-- TOC entry 3487 (class 0 OID 0)
-- Dependencies: 239
-- Name: main_reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_reports_id_seq OWNED BY public.main_reports.id;


--
-- TOC entry 240 (class 1259 OID 53919)
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
-- TOC entry 241 (class 1259 OID 53927)
-- Name: main_transactions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_transactions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_transactions_id_seq OWNER TO postgres;

--
-- TOC entry 3488 (class 0 OID 0)
-- Dependencies: 241
-- Name: main_transactions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_transactions_id_seq OWNED BY public.main_transactions.id;


--
-- TOC entry 242 (class 1259 OID 53929)
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
    vendor_id integer,
    ts timestamp with time zone DEFAULT now()
);


ALTER TABLE public.main_users OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 53935)
-- Name: main_users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.main_users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.main_users_id_seq OWNER TO postgres;

--
-- TOC entry 3489 (class 0 OID 0)
-- Dependencies: 243
-- Name: main_users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.main_users_id_seq OWNED BY public.main_users.id;


--
-- TOC entry 218 (class 1259 OID 51504)
-- Name: payment_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payment_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.payment_status OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 51510)
-- Name: payment_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payment_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.payment_status_id_seq OWNER TO postgres;

--
-- TOC entry 3490 (class 0 OID 0)
-- Dependencies: 219
-- Name: payment_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payment_status_id_seq OWNED BY public.payment_status.id;


--
-- TOC entry 221 (class 1259 OID 51518)
-- Name: print_orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.print_orders (
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


ALTER TABLE public.print_orders OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 51527)
-- Name: print_orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.print_orders_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.print_orders_id_seq OWNER TO postgres;

--
-- TOC entry 3491 (class 0 OID 0)
-- Dependencies: 222
-- Name: print_orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.print_orders_id_seq OWNED BY public.print_orders.id;


--
-- TOC entry 220 (class 1259 OID 51512)
-- Name: print_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.print_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.print_status OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 51529)
-- Name: print_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.print_status_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.print_status_id_seq OWNER TO postgres;

--
-- TOC entry 3492 (class 0 OID 0)
-- Dependencies: 223
-- Name: print_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.print_status_id_seq OWNED BY public.print_status.id;


--
-- TOC entry 224 (class 1259 OID 51531)
-- Name: printers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.printers (
    id integer NOT NULL,
    name text,
    passcode character varying(5),
    email text
);


ALTER TABLE public.printers OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 51537)
-- Name: printers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.printers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.printers_id_seq OWNER TO postgres;

--
-- TOC entry 3493 (class 0 OID 0)
-- Dependencies: 225
-- Name: printers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.printers_id_seq OWNED BY public.printers.id;


--
-- TOC entry 226 (class 1259 OID 51539)
-- Name: report_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.report_types (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.report_types OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 51545)
-- Name: report_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.report_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.report_types_id_seq OWNER TO postgres;

--
-- TOC entry 3494 (class 0 OID 0)
-- Dependencies: 227
-- Name: report_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.report_types_id_seq OWNED BY public.report_types.id;


--
-- TOC entry 244 (class 1259 OID 53937)
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
-- TOC entry 245 (class 1259 OID 53942)
-- Name: sub_media_allocation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_media_allocation_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sub_media_allocation_id_seq OWNER TO postgres;

--
-- TOC entry 3495 (class 0 OID 0)
-- Dependencies: 245
-- Name: sub_media_allocation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sub_media_allocation_id_seq OWNED BY public.sub_media_allocation.id;


--
-- TOC entry 246 (class 1259 OID 53944)
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
-- TOC entry 247 (class 1259 OID 53947)
-- Name: sub_renewal_requests_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_renewal_requests_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sub_renewal_requests_id_seq OWNER TO postgres;

--
-- TOC entry 3496 (class 0 OID 0)
-- Dependencies: 247
-- Name: sub_renewal_requests_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sub_renewal_requests_id_seq OWNED BY public.sub_renewal_requests.id;


--
-- TOC entry 248 (class 1259 OID 53949)
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
-- TOC entry 249 (class 1259 OID 53954)
-- Name: sub_transaction_details_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sub_transaction_details_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sub_transaction_details_id_seq OWNER TO postgres;

--
-- TOC entry 3497 (class 0 OID 0)
-- Dependencies: 249
-- Name: sub_transaction_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sub_transaction_details_id_seq OWNED BY public.sub_transaction_details.id;


--
-- TOC entry 228 (class 1259 OID 51547)
-- Name: user_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.user_types (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.user_types OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 51553)
-- Name: user_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_types_id_seq OWNER TO postgres;

--
-- TOC entry 3498 (class 0 OID 0)
-- Dependencies: 229
-- Name: user_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_types_id_seq OWNED BY public.user_types.id;


--
-- TOC entry 204 (class 1259 OID 51449)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying NOT NULL,
    name character varying NOT NULL,
    username character varying NOT NULL,
    password character varying NOT NULL,
    user_type integer NOT NULL,
    vendor_id integer NOT NULL,
    ts timestamp with time zone DEFAULT now() NOT NULL,
    reports_to integer
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 51555)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 3499 (class 0 OID 0)
-- Dependencies: 230
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 217 (class 1259 OID 51498)
-- Name: vendors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vendors (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.vendors OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 51557)
-- Name: vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vendors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vendors_id_seq OWNER TO postgres;

--
-- TOC entry 3500 (class 0 OID 0)
-- Dependencies: 231
-- Name: vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vendors_id_seq OWNED BY public.vendors.id;


--
-- TOC entry 250 (class 1259 OID 53956)
-- Name: x_bus_depot; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_depot (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.x_bus_depot OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 53962)
-- Name: x_bus_sizes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_sizes (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_bus_sizes OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 53968)
-- Name: x_bus_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_bus_status (
    id integer NOT NULL,
    name character varying NOT NULL,
    availability boolean NOT NULL
);


ALTER TABLE public.x_bus_status OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 53974)
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
-- TOC entry 254 (class 1259 OID 53980)
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
-- TOC entry 255 (class 1259 OID 53986)
-- Name: y_vendors; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_vendors (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.y_vendors OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 53992)
-- Name: view_all_buses; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_all_buses AS
 SELECT main_buses.id,
    main_buses.number,
    ( SELECT y.name
           FROM public.y_platforms y
          WHERE (y.id = main_buses.platform_id)) AS platform,
    ( SELECT o.name
           FROM public.y_operators o
          WHERE (o.id = main_buses.operator_id)) AS operator,
    ( SELECT c.name
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.exterior_campaign_id)) AS exterior_campaign,
    ( SELECT v.name
           FROM public.y_vendors v
          WHERE (v.id = ( SELECT c.vendor_id
                   FROM public.main_campaigns c
                  WHERE (c.id = main_buses.exterior_campaign_id)))) AS exterior_campaign_vendor,
    ( SELECT c.name
           FROM public.main_campaigns c
          WHERE (c.id = main_buses.interior_campaign_id)) AS interior_campaign,
    ( SELECT v.name
           FROM public.y_vendors v
          WHERE (v.id = ( SELECT c.vendor_id
                   FROM public.main_campaigns c
                  WHERE (c.id = main_buses.interior_campaign_id)))) AS interior_campaign_vendor,
    ( SELECT b.name
           FROM public.x_bus_status b
          WHERE (b.id = main_buses.bus_status_id)) AS bus_status,
    ( SELECT b.name
           FROM public.x_bus_sizes b
          WHERE (b.id = main_buses.bus_size_id)) AS bus_size,
    ( SELECT b.name
           FROM public.x_bus_depot b
          WHERE (b.id = main_buses.bus_depot_id)) AS bus_depot,
    main_buses.ts_created,
    main_buses.ts_last_update,
    main_buses.bus_status_id,
    main_buses.bus_size_id,
    main_buses.bus_depot_id,
    main_buses.platform_id,
    main_buses.operator_id,
    main_buses.exterior_campaign_id,
    main_buses.interior_campaign_id
   FROM public.main_buses;


ALTER TABLE public.view_all_buses OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 53997)
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
-- TOC entry 258 (class 1259 OID 54002)
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
-- TOC entry 259 (class 1259 OID 54007)
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
-- TOC entry 260 (class 1259 OID 54012)
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
-- TOC entry 261 (class 1259 OID 54017)
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
-- TOC entry 262 (class 1259 OID 54022)
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
-- TOC entry 263 (class 1259 OID 54026)
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
-- TOC entry 264 (class 1259 OID 54030)
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
-- TOC entry 265 (class 1259 OID 54034)
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
-- TOC entry 266 (class 1259 OID 54038)
-- Name: x_payment_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_payment_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_payment_status OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 54044)
-- Name: x_print_stage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_print_stage (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_print_stage OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 54050)
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
-- TOC entry 269 (class 1259 OID 54056)
-- Name: y_inventory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.y_inventory (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.y_inventory OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 54062)
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
-- TOC entry 271 (class 1259 OID 54070)
-- Name: view_campaigns_pending; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.view_campaigns_pending AS
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
-- TOC entry 272 (class 1259 OID 54075)
-- Name: x_user_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_user_types (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_user_types OWNER TO postgres;

--
-- TOC entry 273 (class 1259 OID 54081)
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
-- TOC entry 274 (class 1259 OID 54085)
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
-- TOC entry 275 (class 1259 OID 54089)
-- Name: x_print_status; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_print_status (
    id integer NOT NULL,
    name character varying NOT NULL
);


ALTER TABLE public.x_print_status OWNER TO postgres;

--
-- TOC entry 276 (class 1259 OID 54095)
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
-- TOC entry 277 (class 1259 OID 54100)
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
-- TOC entry 278 (class 1259 OID 54105)
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
-- TOC entry 279 (class 1259 OID 54110)
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
-- TOC entry 280 (class 1259 OID 54115)
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
-- TOC entry 281 (class 1259 OID 54120)
-- Name: w_vendors_operators; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.w_vendors_operators (
    id integer NOT NULL,
    vendor_id integer,
    operator_id integer
);


ALTER TABLE public.w_vendors_operators OWNER TO postgres;

--
-- TOC entry 282 (class 1259 OID 54123)
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
-- TOC entry 283 (class 1259 OID 54127)
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
-- TOC entry 284 (class 1259 OID 54132)
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
-- TOC entry 285 (class 1259 OID 54137)
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
-- TOC entry 3501 (class 0 OID 0)
-- Dependencies: 285
-- Name: w_vendors_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.w_vendors_operators_id_seq OWNED BY public.w_vendors_operators.id;


--
-- TOC entry 286 (class 1259 OID 54139)
-- Name: x_bus_depot_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_bus_depot_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_bus_depot_id_seq OWNER TO postgres;

--
-- TOC entry 3502 (class 0 OID 0)
-- Dependencies: 286
-- Name: x_bus_depot_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_bus_depot_id_seq OWNED BY public.x_bus_depot.id;


--
-- TOC entry 287 (class 1259 OID 54141)
-- Name: x_bus_sizes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_bus_sizes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_bus_sizes_id_seq OWNER TO postgres;

--
-- TOC entry 3503 (class 0 OID 0)
-- Dependencies: 287
-- Name: x_bus_sizes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_bus_sizes_id_seq OWNED BY public.x_bus_sizes.id;


--
-- TOC entry 288 (class 1259 OID 54143)
-- Name: x_bus_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_bus_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_bus_status_id_seq OWNER TO postgres;

--
-- TOC entry 3504 (class 0 OID 0)
-- Dependencies: 288
-- Name: x_bus_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_bus_status_id_seq OWNED BY public.x_bus_status.id;


--
-- TOC entry 289 (class 1259 OID 54145)
-- Name: x_payment_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_payment_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_payment_status_id_seq OWNER TO postgres;

--
-- TOC entry 3505 (class 0 OID 0)
-- Dependencies: 289
-- Name: x_payment_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_payment_status_id_seq OWNED BY public.x_payment_status.id;


--
-- TOC entry 290 (class 1259 OID 54147)
-- Name: x_print_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_print_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_print_stage_id_seq OWNER TO postgres;

--
-- TOC entry 3506 (class 0 OID 0)
-- Dependencies: 290
-- Name: x_print_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_print_stage_id_seq OWNED BY public.x_print_stage.id;


--
-- TOC entry 291 (class 1259 OID 54149)
-- Name: x_print_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_print_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_print_status_id_seq OWNER TO postgres;

--
-- TOC entry 3507 (class 0 OID 0)
-- Dependencies: 291
-- Name: x_print_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_print_status_id_seq OWNED BY public.x_print_status.id;


--
-- TOC entry 292 (class 1259 OID 54151)
-- Name: x_renewal_stage; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_renewal_stage (
    id integer NOT NULL,
    name text NOT NULL
);


ALTER TABLE public.x_renewal_stage OWNER TO postgres;

--
-- TOC entry 293 (class 1259 OID 54157)
-- Name: x_renewal_stage_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_renewal_stage_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_renewal_stage_id_seq OWNER TO postgres;

--
-- TOC entry 3508 (class 0 OID 0)
-- Dependencies: 293
-- Name: x_renewal_stage_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_renewal_stage_id_seq OWNED BY public.x_renewal_stage.id;


--
-- TOC entry 294 (class 1259 OID 54159)
-- Name: x_report_types; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.x_report_types (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.x_report_types OWNER TO postgres;

--
-- TOC entry 295 (class 1259 OID 54165)
-- Name: x_transaction_status_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_transaction_status_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_transaction_status_id_seq OWNER TO postgres;

--
-- TOC entry 3509 (class 0 OID 0)
-- Dependencies: 295
-- Name: x_transaction_status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_transaction_status_id_seq OWNED BY public.x_transaction_status.id;


--
-- TOC entry 296 (class 1259 OID 54167)
-- Name: x_user_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.x_user_types_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.x_user_types_id_seq OWNER TO postgres;

--
-- TOC entry 3510 (class 0 OID 0)
-- Dependencies: 296
-- Name: x_user_types_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.x_user_types_id_seq OWNED BY public.x_user_types.id;


--
-- TOC entry 297 (class 1259 OID 54169)
-- Name: y_inventory_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.y_inventory_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.y_inventory_id_seq OWNER TO postgres;

--
-- TOC entry 3511 (class 0 OID 0)
-- Dependencies: 297
-- Name: y_inventory_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.y_inventory_id_seq OWNED BY public.y_inventory.id;


--
-- TOC entry 298 (class 1259 OID 54171)
-- Name: y_operators_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.y_operators_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.y_operators_id_seq OWNER TO postgres;

--
-- TOC entry 3512 (class 0 OID 0)
-- Dependencies: 298
-- Name: y_operators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.y_operators_id_seq OWNED BY public.y_operators.id;


--
-- TOC entry 299 (class 1259 OID 54173)
-- Name: y_platforms_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.y_platforms_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.y_platforms_id_seq OWNER TO postgres;

--
-- TOC entry 3513 (class 0 OID 0)
-- Dependencies: 299
-- Name: y_platforms_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.y_platforms_id_seq OWNED BY public.y_platforms.id;


--
-- TOC entry 300 (class 1259 OID 54175)
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
-- TOC entry 301 (class 1259 OID 54181)
-- Name: y_printers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.y_printers_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.y_printers_id_seq OWNER TO postgres;

--
-- TOC entry 3514 (class 0 OID 0)
-- Dependencies: 301
-- Name: y_printers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.y_printers_id_seq OWNED BY public.y_printers.id;


--
-- TOC entry 302 (class 1259 OID 54183)
-- Name: y_vendors_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.y_vendors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.y_vendors_id_seq OWNER TO postgres;

--
-- TOC entry 3515 (class 0 OID 0)
-- Dependencies: 302
-- Name: y_vendors_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.y_vendors_id_seq OWNED BY public.y_vendors.id;


--
-- TOC entry 303 (class 1259 OID 54185)
-- Name: z_core_settings; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.z_core_settings (
    id integer NOT NULL,
    name character varying NOT NULL,
    value character varying NOT NULL
);


ALTER TABLE public.z_core_settings OWNER TO postgres;

--
-- TOC entry 304 (class 1259 OID 54191)
-- Name: z_core_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.z_core_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.z_core_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3516 (class 0 OID 0)
-- Dependencies: 304
-- Name: z_core_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.z_core_settings_id_seq OWNED BY public.z_core_settings.id;


--
-- TOC entry 305 (class 1259 OID 54193)
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
-- TOC entry 306 (class 1259 OID 54199)
-- Name: z_email_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.z_email_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.z_email_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3517 (class 0 OID 0)
-- Dependencies: 306
-- Name: z_email_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.z_email_settings_id_seq OWNED BY public.z_email_settings.id;


--
-- TOC entry 307 (class 1259 OID 54201)
-- Name: z_price_settings_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.z_price_settings_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.z_price_settings_id_seq OWNER TO postgres;

--
-- TOC entry 3518 (class 0 OID 0)
-- Dependencies: 307
-- Name: z_price_settings_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.z_price_settings_id_seq OWNED BY public.z_price_settings.id;


--
-- TOC entry 3091 (class 2604 OID 51559)
-- Name: bus_depot id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_depot ALTER COLUMN id SET DEFAULT nextval('public.bus_depot_id_seq'::regclass);


--
-- TOC entry 3096 (class 2604 OID 51560)
-- Name: bus_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_status ALTER COLUMN id SET DEFAULT nextval('public.bus_status_id_seq'::regclass);


--
-- TOC entry 3095 (class 2604 OID 51561)
-- Name: buses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses ALTER COLUMN id SET DEFAULT nextval('public.buses_id_seq'::regclass);


--
-- TOC entry 3106 (class 2604 OID 51562)
-- Name: campaign_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaign_status ALTER COLUMN id SET DEFAULT nextval('public.campaign_status_id_seq'::regclass);


--
-- TOC entry 3107 (class 2604 OID 51563)
-- Name: core_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.core_settings ALTER COLUMN id SET DEFAULT nextval('public.core_settings_id_seq'::regclass);


--
-- TOC entry 3108 (class 2604 OID 51564)
-- Name: discounts id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.discounts ALTER COLUMN id SET DEFAULT nextval('public.discounts_id_seq'::regclass);


--
-- TOC entry 3109 (class 2604 OID 51565)
-- Name: email_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.email_settings ALTER COLUMN id SET DEFAULT nextval('public.email_settings_id_seq'::regclass);


--
-- TOC entry 3103 (class 2604 OID 51566)
-- Name: exterior_campaigns id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns ALTER COLUMN id SET DEFAULT nextval('public.exterior_campaigns_id_seq'::regclass);


--
-- TOC entry 3111 (class 2604 OID 51567)
-- Name: exterior_reports id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_reports ALTER COLUMN id SET DEFAULT nextval('public.exterior_reports_id_seq'::regclass);


--
-- TOC entry 3125 (class 2604 OID 54203)
-- Name: main_buses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses ALTER COLUMN id SET DEFAULT nextval('public.main_buses_id_seq'::regclass);


--
-- TOC entry 3129 (class 2604 OID 54204)
-- Name: main_campaigns id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns ALTER COLUMN id SET DEFAULT nextval('public.main_campaigns_id_seq'::regclass);


--
-- TOC entry 3133 (class 2604 OID 54205)
-- Name: main_print_orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_print_orders ALTER COLUMN id SET DEFAULT nextval('public.main_print_orders_id_seq'::regclass);


--
-- TOC entry 3135 (class 2604 OID 54206)
-- Name: main_reports id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports ALTER COLUMN id SET DEFAULT nextval('public.main_reports_id_seq'::regclass);


--
-- TOC entry 3141 (class 2604 OID 54207)
-- Name: main_transactions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_transactions ALTER COLUMN id SET DEFAULT nextval('public.main_transactions_id_seq'::regclass);


--
-- TOC entry 3142 (class 2604 OID 54208)
-- Name: main_users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_users ALTER COLUMN id SET DEFAULT nextval('public.main_users_id_seq'::regclass);


--
-- TOC entry 3113 (class 2604 OID 51568)
-- Name: payment_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_status ALTER COLUMN id SET DEFAULT nextval('public.payment_status_id_seq'::regclass);


--
-- TOC entry 3118 (class 2604 OID 51569)
-- Name: print_orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_orders ALTER COLUMN id SET DEFAULT nextval('public.print_orders_id_seq'::regclass);


--
-- TOC entry 3114 (class 2604 OID 51570)
-- Name: print_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_status ALTER COLUMN id SET DEFAULT nextval('public.print_status_id_seq'::regclass);


--
-- TOC entry 3119 (class 2604 OID 51571)
-- Name: printers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.printers ALTER COLUMN id SET DEFAULT nextval('public.printers_id_seq'::regclass);


--
-- TOC entry 3120 (class 2604 OID 51572)
-- Name: report_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.report_types ALTER COLUMN id SET DEFAULT nextval('public.report_types_id_seq'::regclass);


--
-- TOC entry 3146 (class 2604 OID 54209)
-- Name: sub_media_allocation id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation ALTER COLUMN id SET DEFAULT nextval('public.sub_media_allocation_id_seq'::regclass);


--
-- TOC entry 3147 (class 2604 OID 54210)
-- Name: sub_renewal_requests id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_renewal_requests ALTER COLUMN id SET DEFAULT nextval('public.sub_renewal_requests_id_seq'::regclass);


--
-- TOC entry 3150 (class 2604 OID 54211)
-- Name: sub_transaction_details id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_transaction_details ALTER COLUMN id SET DEFAULT nextval('public.sub_transaction_details_id_seq'::regclass);


--
-- TOC entry 3121 (class 2604 OID 51573)
-- Name: user_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_types ALTER COLUMN id SET DEFAULT nextval('public.user_types_id_seq'::regclass);


--
-- TOC entry 3105 (class 2604 OID 51574)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 3112 (class 2604 OID 51575)
-- Name: vendors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendors ALTER COLUMN id SET DEFAULT nextval('public.vendors_id_seq'::regclass);


--
-- TOC entry 3166 (class 2604 OID 54212)
-- Name: w_vendors_operators id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.w_vendors_operators ALTER COLUMN id SET DEFAULT nextval('public.w_vendors_operators_id_seq'::regclass);


--
-- TOC entry 3151 (class 2604 OID 54213)
-- Name: x_bus_depot id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot ALTER COLUMN id SET DEFAULT nextval('public.x_bus_depot_id_seq'::regclass);


--
-- TOC entry 3152 (class 2604 OID 54214)
-- Name: x_bus_sizes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_sizes ALTER COLUMN id SET DEFAULT nextval('public.x_bus_sizes_id_seq'::regclass);


--
-- TOC entry 3153 (class 2604 OID 54215)
-- Name: x_bus_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status ALTER COLUMN id SET DEFAULT nextval('public.x_bus_status_id_seq'::regclass);


--
-- TOC entry 3157 (class 2604 OID 54216)
-- Name: x_payment_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status ALTER COLUMN id SET DEFAULT nextval('public.x_payment_status_id_seq'::regclass);


--
-- TOC entry 3158 (class 2604 OID 54217)
-- Name: x_print_stage id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_stage ALTER COLUMN id SET DEFAULT nextval('public.x_print_stage_id_seq'::regclass);


--
-- TOC entry 3165 (class 2604 OID 54218)
-- Name: x_print_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status ALTER COLUMN id SET DEFAULT nextval('public.x_print_status_id_seq'::regclass);


--
-- TOC entry 3167 (class 2604 OID 54219)
-- Name: x_renewal_stage id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_renewal_stage ALTER COLUMN id SET DEFAULT nextval('public.x_renewal_stage_id_seq'::regclass);


--
-- TOC entry 3159 (class 2604 OID 54220)
-- Name: x_transaction_status id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_transaction_status ALTER COLUMN id SET DEFAULT nextval('public.x_transaction_status_id_seq'::regclass);


--
-- TOC entry 3164 (class 2604 OID 54221)
-- Name: x_user_types id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_user_types ALTER COLUMN id SET DEFAULT nextval('public.x_user_types_id_seq'::regclass);


--
-- TOC entry 3160 (class 2604 OID 54222)
-- Name: y_inventory id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_inventory ALTER COLUMN id SET DEFAULT nextval('public.y_inventory_id_seq'::regclass);


--
-- TOC entry 3154 (class 2604 OID 54223)
-- Name: y_operators id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators ALTER COLUMN id SET DEFAULT nextval('public.y_operators_id_seq'::regclass);


--
-- TOC entry 3155 (class 2604 OID 54224)
-- Name: y_platforms id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_platforms ALTER COLUMN id SET DEFAULT nextval('public.y_platforms_id_seq'::regclass);


--
-- TOC entry 3168 (class 2604 OID 54225)
-- Name: y_printers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_printers ALTER COLUMN id SET DEFAULT nextval('public.y_printers_id_seq'::regclass);


--
-- TOC entry 3156 (class 2604 OID 54226)
-- Name: y_vendors id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_vendors ALTER COLUMN id SET DEFAULT nextval('public.y_vendors_id_seq'::regclass);


--
-- TOC entry 3169 (class 2604 OID 54227)
-- Name: z_core_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_core_settings ALTER COLUMN id SET DEFAULT nextval('public.z_core_settings_id_seq'::regclass);


--
-- TOC entry 3170 (class 2604 OID 54228)
-- Name: z_email_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings ALTER COLUMN id SET DEFAULT nextval('public.z_email_settings_id_seq'::regclass);


--
-- TOC entry 3163 (class 2604 OID 54229)
-- Name: z_price_settings id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_price_settings ALTER COLUMN id SET DEFAULT nextval('public.z_price_settings_id_seq'::regclass);


--
-- TOC entry 3243 (class 2606 OID 54231)
-- Name: sub_media_allocation allocation_bus_campaign_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_campaign_uk UNIQUE (bus_id, campaign_id);


--
-- TOC entry 3172 (class 2606 OID 51577)
-- Name: bus_depot bus_depot_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_depot
    ADD CONSTRAINT bus_depot_pk PRIMARY KEY (id);


--
-- TOC entry 3174 (class 2606 OID 51579)
-- Name: bus_depot bus_depot_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_depot
    ADD CONSTRAINT bus_depot_unique UNIQUE (name);


--
-- TOC entry 3180 (class 2606 OID 51581)
-- Name: bus_status bus_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_status
    ADD CONSTRAINT bus_status_name_key UNIQUE (name);


--
-- TOC entry 3182 (class 2606 OID 51583)
-- Name: bus_status bus_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bus_status
    ADD CONSTRAINT bus_status_pk PRIMARY KEY (id);


--
-- TOC entry 3176 (class 2606 OID 51585)
-- Name: buses buses_number_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses
    ADD CONSTRAINT buses_number_key UNIQUE (number);


--
-- TOC entry 3178 (class 2606 OID 51587)
-- Name: buses buses_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses
    ADD CONSTRAINT buses_pk PRIMARY KEY (id);


--
-- TOC entry 3194 (class 2606 OID 51589)
-- Name: campaign_status campaign_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaign_status
    ADD CONSTRAINT campaign_status_name_key UNIQUE (name);


--
-- TOC entry 3196 (class 2606 OID 51591)
-- Name: campaign_status campaign_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.campaign_status
    ADD CONSTRAINT campaign_status_pk PRIMARY KEY (id);


--
-- TOC entry 3198 (class 2606 OID 51593)
-- Name: discounts discounts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.discounts
    ADD CONSTRAINT discounts_pkey PRIMARY KEY (id);


--
-- TOC entry 3200 (class 2606 OID 51595)
-- Name: email_settings email_settings_name_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.email_settings
    ADD CONSTRAINT email_settings_name_uk UNIQUE (name);


--
-- TOC entry 3202 (class 2606 OID 51597)
-- Name: email_settings email_settings_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.email_settings
    ADD CONSTRAINT email_settings_pk PRIMARY KEY (id);


--
-- TOC entry 3184 (class 2606 OID 51599)
-- Name: exterior_campaigns exterior_campaigns_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_pk PRIMARY KEY (id);


--
-- TOC entry 3204 (class 2606 OID 51601)
-- Name: exterior_reports exterior_reports_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_reports
    ADD CONSTRAINT exterior_reports_pk PRIMARY KEY (id);


--
-- TOC entry 3229 (class 2606 OID 54233)
-- Name: main_buses main_buses_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_id_pk PRIMARY KEY (id);


--
-- TOC entry 3231 (class 2606 OID 54235)
-- Name: main_buses main_buses_number_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_number_uk UNIQUE (number);


--
-- TOC entry 3233 (class 2606 OID 54237)
-- Name: main_campaigns main_campaigns_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT main_campaigns_id_pk PRIMARY KEY (id);


--
-- TOC entry 3237 (class 2606 OID 54239)
-- Name: main_reports main_exterior_reports_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT main_exterior_reports_id_pk PRIMARY KEY (id);


--
-- TOC entry 3235 (class 2606 OID 54241)
-- Name: main_print_orders main_print_orders_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_print_orders
    ADD CONSTRAINT main_print_orders_pk PRIMARY KEY (id);


--
-- TOC entry 3239 (class 2606 OID 54243)
-- Name: main_transactions main_transactions_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_transactions
    ADD CONSTRAINT main_transactions_id_pk PRIMARY KEY (id);


--
-- TOC entry 3241 (class 2606 OID 54245)
-- Name: main_users main_users_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_users
    ADD CONSTRAINT main_users_id_pk PRIMARY KEY (id);


--
-- TOC entry 3210 (class 2606 OID 51603)
-- Name: payment_status payment_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_status
    ADD CONSTRAINT payment_status_name_key UNIQUE (name);


--
-- TOC entry 3212 (class 2606 OID 51605)
-- Name: payment_status payment_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payment_status
    ADD CONSTRAINT payment_status_pk PRIMARY KEY (id);


--
-- TOC entry 3218 (class 2606 OID 51607)
-- Name: print_orders print_orders_pk0; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_orders
    ADD CONSTRAINT print_orders_pk0 PRIMARY KEY (id);


--
-- TOC entry 3220 (class 2606 OID 51609)
-- Name: print_orders print_orders_uk0; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_orders
    ADD CONSTRAINT print_orders_uk0 UNIQUE (campaign_id, printer_id);


--
-- TOC entry 3214 (class 2606 OID 51611)
-- Name: print_status print_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_status
    ADD CONSTRAINT print_status_name_key UNIQUE (name);


--
-- TOC entry 3216 (class 2606 OID 51613)
-- Name: print_status print_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_status
    ADD CONSTRAINT print_status_pk PRIMARY KEY (id);


--
-- TOC entry 3222 (class 2606 OID 51615)
-- Name: printers printers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.printers
    ADD CONSTRAINT printers_pkey PRIMARY KEY (id);


--
-- TOC entry 3224 (class 2606 OID 51617)
-- Name: report_types report_types_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.report_types
    ADD CONSTRAINT report_types_pk PRIMARY KEY (id);


--
-- TOC entry 3245 (class 2606 OID 54247)
-- Name: sub_media_allocation sub_media_allocation_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT sub_media_allocation_id_pk PRIMARY KEY (id);


--
-- TOC entry 3247 (class 2606 OID 54249)
-- Name: sub_renewal_requests sub_renewal_requests_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_renewal_requests
    ADD CONSTRAINT sub_renewal_requests_id_pk PRIMARY KEY (id);


--
-- TOC entry 3249 (class 2606 OID 54251)
-- Name: sub_transaction_details sub_transaction_details_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_transaction_details
    ADD CONSTRAINT sub_transaction_details_id_pk PRIMARY KEY (id);


--
-- TOC entry 3226 (class 2606 OID 51619)
-- Name: user_types user_types_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.user_types
    ADD CONSTRAINT user_types_pk PRIMARY KEY (id);


--
-- TOC entry 3186 (class 2606 OID 51621)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 3188 (class 2606 OID 51623)
-- Name: users users_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_name_key UNIQUE (name);


--
-- TOC entry 3190 (class 2606 OID 51625)
-- Name: users users_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY (id);


--
-- TOC entry 3192 (class 2606 OID 51627)
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- TOC entry 3206 (class 2606 OID 51629)
-- Name: vendors vendors_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendors
    ADD CONSTRAINT vendors_name_key UNIQUE (name);


--
-- TOC entry 3208 (class 2606 OID 51631)
-- Name: vendors vendors_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vendors
    ADD CONSTRAINT vendors_pk PRIMARY KEY (id);


--
-- TOC entry 3285 (class 2606 OID 54253)
-- Name: w_vendors_operators w_vendors_operators_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.w_vendors_operators
    ADD CONSTRAINT w_vendors_operators_id_pk PRIMARY KEY (id);


--
-- TOC entry 3251 (class 2606 OID 54255)
-- Name: x_bus_depot x_bus_depot_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT x_bus_depot_pk PRIMARY KEY (id);


--
-- TOC entry 3253 (class 2606 OID 54257)
-- Name: x_bus_depot x_bus_depot_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_depot
    ADD CONSTRAINT x_bus_depot_unique UNIQUE (name);


--
-- TOC entry 3255 (class 2606 OID 54259)
-- Name: x_bus_sizes x_bus_sizes_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_sizes
    ADD CONSTRAINT x_bus_sizes_id_pk PRIMARY KEY (id);


--
-- TOC entry 3257 (class 2606 OID 54261)
-- Name: x_bus_status x_bus_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT x_bus_status_name_key UNIQUE (name);


--
-- TOC entry 3259 (class 2606 OID 54263)
-- Name: x_bus_status x_bus_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_bus_status
    ADD CONSTRAINT x_bus_status_pk PRIMARY KEY (id);


--
-- TOC entry 3273 (class 2606 OID 54265)
-- Name: x_transaction_status x_campaign_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_transaction_status
    ADD CONSTRAINT x_campaign_status_pk PRIMARY KEY (id);


--
-- TOC entry 3267 (class 2606 OID 54267)
-- Name: x_payment_status x_payment_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT x_payment_status_name_key UNIQUE (name);


--
-- TOC entry 3269 (class 2606 OID 54269)
-- Name: x_payment_status x_payment_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_payment_status
    ADD CONSTRAINT x_payment_status_pk PRIMARY KEY (id);


--
-- TOC entry 3271 (class 2606 OID 54271)
-- Name: x_print_stage x_print_stage_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_stage
    ADD CONSTRAINT x_print_stage_id_pk PRIMARY KEY (id);


--
-- TOC entry 3281 (class 2606 OID 54273)
-- Name: x_print_status x_print_status_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT x_print_status_name_key UNIQUE (name);


--
-- TOC entry 3283 (class 2606 OID 54275)
-- Name: x_print_status x_print_status_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_print_status
    ADD CONSTRAINT x_print_status_pk PRIMARY KEY (id);


--
-- TOC entry 3287 (class 2606 OID 54277)
-- Name: x_renewal_stage x_renewal_stage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_renewal_stage
    ADD CONSTRAINT x_renewal_stage_pkey PRIMARY KEY (id);


--
-- TOC entry 3289 (class 2606 OID 54279)
-- Name: x_report_types x_report_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_report_types
    ADD CONSTRAINT x_report_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3279 (class 2606 OID 54281)
-- Name: x_user_types x_user_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.x_user_types
    ADD CONSTRAINT x_user_types_pkey PRIMARY KEY (id);


--
-- TOC entry 3275 (class 2606 OID 54283)
-- Name: y_inventory y_inventory_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_inventory
    ADD CONSTRAINT y_inventory_id_pk PRIMARY KEY (id);


--
-- TOC entry 3261 (class 2606 OID 54285)
-- Name: y_operators y_operator_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT y_operator_id_pk PRIMARY KEY (id);


--
-- TOC entry 3263 (class 2606 OID 54287)
-- Name: y_platforms y_platform_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_platforms
    ADD CONSTRAINT y_platform_id_pk PRIMARY KEY (id);


--
-- TOC entry 3291 (class 2606 OID 54289)
-- Name: y_printers y_printers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_printers
    ADD CONSTRAINT y_printers_pkey PRIMARY KEY (id);


--
-- TOC entry 3265 (class 2606 OID 54291)
-- Name: y_vendors y_vendors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_vendors
    ADD CONSTRAINT y_vendors_pkey PRIMARY KEY (id);


--
-- TOC entry 3293 (class 2606 OID 54293)
-- Name: z_core_settings z_core_settings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_core_settings
    ADD CONSTRAINT z_core_settings_pkey PRIMARY KEY (id);


--
-- TOC entry 3295 (class 2606 OID 54295)
-- Name: z_email_settings z_email_settings_name_uk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT z_email_settings_name_uk UNIQUE (name);


--
-- TOC entry 3297 (class 2606 OID 54297)
-- Name: z_email_settings z_email_settings_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_email_settings
    ADD CONSTRAINT z_email_settings_pk PRIMARY KEY (id);


--
-- TOC entry 3277 (class 2606 OID 54299)
-- Name: z_price_settings z_pricing_id_pk; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.z_price_settings
    ADD CONSTRAINT z_pricing_id_pk PRIMARY KEY (id);


--
-- TOC entry 3227 (class 1259 OID 54300)
-- Name: fki_main_buses_depot_fk; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_main_buses_depot_fk ON public.main_buses USING btree (bus_depot_id);


--
-- TOC entry 3458 (class 2618 OID 54037)
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
-- TOC entry 3325 (class 2606 OID 54302)
-- Name: sub_media_allocation allocation_bus_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_bus_id_fk FOREIGN KEY (bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3326 (class 2606 OID 54307)
-- Name: sub_media_allocation allocation_campaign_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sub_media_allocation
    ADD CONSTRAINT allocation_campaign_id_fk FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3319 (class 2606 OID 54312)
-- Name: main_campaigns bus_size_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT bus_size_id_fk FOREIGN KEY (bus_size_id) REFERENCES public.x_bus_sizes(id);


--
-- TOC entry 3298 (class 2606 OID 51632)
-- Name: buses buses_depot_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses
    ADD CONSTRAINT buses_depot_fk FOREIGN KEY (bus_depot_id) REFERENCES public.bus_depot(id);


--
-- TOC entry 3299 (class 2606 OID 51637)
-- Name: buses buses_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses
    ADD CONSTRAINT buses_fk1 FOREIGN KEY (exterior_campaign_id) REFERENCES public.exterior_campaigns(id) ON DELETE SET NULL;


--
-- TOC entry 3300 (class 2606 OID 51642)
-- Name: buses buses_fk3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.buses
    ADD CONSTRAINT buses_fk3 FOREIGN KEY (bus_status_id) REFERENCES public.bus_status(id);


--
-- TOC entry 3311 (class 2606 OID 51647)
-- Name: print_orders exterior_campaign_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_orders
    ADD CONSTRAINT exterior_campaign_fk0 FOREIGN KEY (campaign_id) REFERENCES public.exterior_campaigns(id);


--
-- TOC entry 3301 (class 2606 OID 51652)
-- Name: exterior_campaigns exterior_campaigns_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_fk1 FOREIGN KEY (created_by) REFERENCES public.users(id);


--
-- TOC entry 3302 (class 2606 OID 51657)
-- Name: exterior_campaigns exterior_campaigns_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_fk2 FOREIGN KEY (vendor_id) REFERENCES public.vendors(id);


--
-- TOC entry 3303 (class 2606 OID 51662)
-- Name: exterior_campaigns exterior_campaigns_fk3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_fk3 FOREIGN KEY (status_id) REFERENCES public.campaign_status(id);


--
-- TOC entry 3304 (class 2606 OID 51667)
-- Name: exterior_campaigns exterior_campaigns_fk4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_fk4 FOREIGN KEY (print_status_id) REFERENCES public.print_status(id);


--
-- TOC entry 3305 (class 2606 OID 51672)
-- Name: exterior_campaigns exterior_campaigns_fk5; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_campaigns
    ADD CONSTRAINT exterior_campaigns_fk5 FOREIGN KEY (payment_status_id) REFERENCES public.payment_status(id);


--
-- TOC entry 3308 (class 2606 OID 51677)
-- Name: exterior_reports exterior_reports_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_reports
    ADD CONSTRAINT exterior_reports_fk0 FOREIGN KEY (vendor_id) REFERENCES public.vendors(id);


--
-- TOC entry 3309 (class 2606 OID 51682)
-- Name: exterior_reports exterior_reports_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_reports
    ADD CONSTRAINT exterior_reports_fk1 FOREIGN KEY (ref_bus_id) REFERENCES public.buses(id);


--
-- TOC entry 3323 (class 2606 OID 54317)
-- Name: main_reports exterior_reports_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk1 FOREIGN KEY (ref_bus_id) REFERENCES public.main_buses(id);


--
-- TOC entry 3310 (class 2606 OID 51687)
-- Name: exterior_reports exterior_reports_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.exterior_reports
    ADD CONSTRAINT exterior_reports_fk2 FOREIGN KEY (campaign_id) REFERENCES public.exterior_campaigns(id);


--
-- TOC entry 3324 (class 2606 OID 54322)
-- Name: main_reports exterior_reports_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_reports
    ADD CONSTRAINT exterior_reports_fk2 FOREIGN KEY (campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3320 (class 2606 OID 54327)
-- Name: main_campaigns inventory_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT inventory_id_fk FOREIGN KEY (inventory_id) REFERENCES public.y_inventory(id);


--
-- TOC entry 3313 (class 2606 OID 54332)
-- Name: main_buses main_buses_depot_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_depot_fk FOREIGN KEY (bus_depot_id) REFERENCES public.x_bus_depot(id);


--
-- TOC entry 3314 (class 2606 OID 54337)
-- Name: main_buses main_buses_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk0 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3315 (class 2606 OID 54342)
-- Name: main_buses main_buses_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk1 FOREIGN KEY (exterior_campaign_id) REFERENCES public.main_campaigns(id) ON DELETE SET NULL;


--
-- TOC entry 3316 (class 2606 OID 54347)
-- Name: main_buses main_buses_fk2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk2 FOREIGN KEY (interior_campaign_id) REFERENCES public.main_campaigns(id);


--
-- TOC entry 3317 (class 2606 OID 54352)
-- Name: main_buses main_buses_fk3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk3 FOREIGN KEY (bus_status_id) REFERENCES public.x_bus_status(id);


--
-- TOC entry 3318 (class 2606 OID 54357)
-- Name: main_buses main_buses_fk4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_buses
    ADD CONSTRAINT main_buses_fk4 FOREIGN KEY (operator_id) REFERENCES public.y_operators(id);


--
-- TOC entry 3327 (class 2606 OID 54362)
-- Name: y_operators operator_platorm_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.y_operators
    ADD CONSTRAINT operator_platorm_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3321 (class 2606 OID 54367)
-- Name: main_campaigns platform_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT platform_id_fk FOREIGN KEY (platform_id) REFERENCES public.y_platforms(id);


--
-- TOC entry 3322 (class 2606 OID 54372)
-- Name: main_campaigns pricing_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.main_campaigns
    ADD CONSTRAINT pricing_id_fk FOREIGN KEY (price_id) REFERENCES public.z_price_settings(id);


--
-- TOC entry 3312 (class 2606 OID 51692)
-- Name: print_orders printer_id_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.print_orders
    ADD CONSTRAINT printer_id_fk0 FOREIGN KEY (printer_id) REFERENCES public.printers(id);


--
-- TOC entry 3306 (class 2606 OID 51697)
-- Name: users users_fk0; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_fk0 FOREIGN KEY (user_type) REFERENCES public.user_types(id);


--
-- TOC entry 3307 (class 2606 OID 51702)
-- Name: users users_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_fk1 FOREIGN KEY (vendor_id) REFERENCES public.vendors(id);


-- Completed on 2020-12-09 11:57:25

--
-- PostgreSQL database dump complete
--

