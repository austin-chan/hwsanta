//
//  TheNavigationController.m
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import "TheNavigationController.h"
#import "GameState.h"
#import "SantaModel.h"

@interface TheNavigationController (){
    NSMutableData *responseData;
}

@end

@implementation TheNavigationController

- (void)viewDidLoad
{
    [super viewDidLoad];
    [self launch];

    // Do any additional setup after loading the view.
}

- (void)login{

    [self dismissViewControllerAnimated:NO completion:nil];
    [self launch];
}

- (void)launch{
    [self launchToRegister];
    GameState *state = [GameState sharedGameState];
    NSString *stage = [state getStage];
    if([stage isEqualToString:@"verification"]){
        [self nextAfterRules];
    }else if([stage isEqualToString:@"setup"]){
        [self nextAfterVerification];
    }else if([stage isEqualToString:@"setupComplete"]){
        [self doneSetup];
    }else if([stage isEqualToString:@"selectPrep"]){
        [self nextAfterSetupComplete];
    }else if([stage isEqualToString:@"selectNow"]){
        [self nextAfterSelectPrep];
        [self selectUserID:nil];
    }else if([stage isEqualToString:@"tabs"]){
        [self shiftToTabs];
    }
}

- (void)launchToRegister{
    self.navigationBarHidden = YES;
    UIViewController *registerScreen = [self getViewScreen:@"registerScreen"];
    [self setViewControllers:[NSArray arrayWithObject:registerScreen]];
}

- (void)nextAfterRegister{
    UIViewController *acceptRulesScreen = [self getViewScreen:@"acceptRulesScreen"];
    [self pushViewController:acceptRulesScreen animated:YES];
}

- (void)nextAfterRules{
    [self popViewControllerAnimated:NO];
    
    UIViewController *verificationScreen = [self getViewScreen:@"verificationScreen"];
    [self pushViewController:verificationScreen animated:YES];
    [[GameState sharedGameState] saveStage:@"verification"];
    
}
-(void)backBeforeRules{
    [self popViewControllerAnimated:YES];
}

- (void)nextAfterVerification{
    [self popToRootViewControllerAnimated:NO];
    self.navigationBarHidden = NO;
    
    UIViewController *setupScreen = [self getViewScreen:@"setupScreen"];
    [self pushViewController:setupScreen animated:YES];
    
    [[GameState sharedGameState] saveStage:@"setup"];
}


- (void)doneSetup{
    [self popViewControllerAnimated:NO];

    UIViewController *setupCompleteScreen = [self getViewScreen:@"setupCompleteScreen"];
    [self setViewControllers:[NSArray arrayWithObject:setupCompleteScreen] animated:YES];
    [self setNavigationBarHidden:YES animated:YES];
    [[GameState sharedGameState] saveStage:@"setupComplete"];
}

- (void)nextAfterSetupComplete{
    [self popViewControllerAnimated:NO];

    UIViewController *selectionPrepScreen = [self getViewScreen:@"selectPrepScreen"];
    [self setViewControllers:[NSArray arrayWithObject:selectionPrepScreen] animated:YES];
    
    [[GameState sharedGameState] saveStage:@"selectPrep"];
}

- (void)nextAfterSelectPrep{
    UIViewController *selectNowScreen = [self getViewScreen:@"selectNowScreen"];
    [self pushViewController:selectNowScreen animated:YES];
    
    [[GameState sharedGameState] saveStage:@"selectNow"];
}

- (void)selectUserID:(NSString *)userid{
    NSArray *choices = [[GameState sharedGameState] getSelectionChoices];
    if(userid == nil){
        NSUInteger randomIndex = arc4random() % [choices count];
        userid = [[choices objectAtIndex:randomIndex] objectForKey:@"userid"];
    }
    
    NSString *unselected = @"";
    for(int x = 0; x < [choices count]; x++){
        NSString *choiceID = [NSString stringWithFormat:@"%@",[[choices objectAtIndex:x] objectForKey:@"userid"]];
        if(![choiceID isEqualToString:userid]){
            unselected = [unselected stringByAppendingString:choiceID];
            unselected = [unselected stringByAppendingString:@","];
        }
    }
    NSString *selected = userid;
    NSString *thisid = [[GameState sharedGameState] getUserID];
    
    NSString *sendString = [NSString stringWithFormat:@"http://hwsanta.com/app/select.php?userid=%@&selected=%@&unselected=%@", thisid, selected, unselected];
    NSURLRequest *request = [NSURLRequest requestWithURL:[NSURL URLWithString:[sendString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]]];
    
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}


- (void)shiftToTabs{
    UIViewController *tabBarScreen = [self getViewScreen:@"tabBarScreen"];
    [self setViewControllers:[NSArray arrayWithObject:tabBarScreen]];

    [[GameState sharedGameState] saveStage:@"tabs"];
}

- (void)swipedUpToSignIn{
    UIViewController *login = [self getViewScreen:@"loginScreen"];
    [self presentViewController:login animated:YES completion:nil];
}

- (UIViewController *)getViewScreen:(NSString *)screen{
    UIStoryboard *storyBoard = [UIStoryboard storyboardWithName:@"MainStoryboard" bundle:[NSBundle mainBundle]];
    UIViewController *view = [storyBoard instantiateViewControllerWithIdentifier:screen];
    return view;
}














- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response
{
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data
{
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error
{
    [[[UIAlertView alloc] initWithTitle:@"Error" message:@"Could not connect to server" delegate:nil cancelButtonTitle:@"Ok" otherButtonTitles: nil] show];
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    //NSString *response = [[NSString alloc] initWithData:responseData encoding: NSASCIIStringEncoding];
    
    [self shiftToTabs];
    
}

@end
