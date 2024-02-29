

export interface sessionI{
    agent: agentI,
    ip_address: string,
    is_current_device: boolean,
    last_active: string
}

interface agentI{
    browser: string,
    is_desktop: false,
    platform: string
}
